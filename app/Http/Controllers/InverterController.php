<?php

namespace App\Http\Controllers;

use App\Models\Inverter;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InverterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inverters = Inverter::all();
        return view('inverters.index', compact('inverters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inverters.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'model' => 'nullable|string|max:255',
            'power_rating' => 'required|numeric|min:0',
            'quantity_in_stock' => 'required|integer|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'warranty' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:255',
        ]);

        $inverter = Inverter::create($validated);

        // Create transaction record
        $transaction = Transaction::create([
            'date' => now()->toDateString(),
            'reference' => '', // Will be updated below
            'product_type' => 'inverter',
            'particulars' => 'Added ' . $inverter->product_name . ' (' . $inverter->model . ')',
            'qty' => $inverter->quantity_in_stock,
            'remarks' => $request->remarks ?? 'Initial stock added'
        ]);

        // Generate and update reference with format: 000 + date + id
        $reference = $this->generateReference($transaction->date, $transaction->id);
        $transaction->update(['reference' => $reference]);

        return redirect()->route('inverters.index')->with('success', 'Inverter added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Inverter $inverter)
    {
        return view('inverters.show', compact('inverter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inverter $inverter)
    {
        return view('inverters.edit', compact('inverter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inverter $inverter)
    {
        $oldQty = $inverter->quantity_in_stock;

        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'model' => 'nullable|string|max:255',
            'power_rating' => 'required|numeric|min:0',
            'quantity_in_stock' => 'required|integer|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'warranty' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:255',
        ]);

        $inverter->update($validated);

        // Create transaction record if quantity changed
        $qtyDifference = $inverter->quantity_in_stock - $oldQty;
        if ($qtyDifference != 0) {
            $transaction = Transaction::create([
                'date' => now()->toDateString(),
                'reference' => '', // Will be updated below
                'product_type' => 'inverter',
                'particulars' => ($qtyDifference > 0 ? 'Stock added: ' : 'Stock removed: ') . $inverter->product_name,
                'qty' => $qtyDifference,
                'remarks' => $request->remarks ?? 'Quantity updated from ' . $oldQty . ' to ' . $inverter->quantity_in_stock
            ]);

            // Generate and update reference with format: 000 + date + id
            $reference = $this->generateReference($transaction->date, $transaction->id);
            $transaction->update(['reference' => $reference]);
        }

        return redirect()->route('inverters.index')->with('success', 'Inverter updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inverter $inverter)
    {
        $inverter->delete();
        return redirect()->route('inverters.index')->with('success', 'Inverter deleted successfully');
    }

    /**
     * Show the form for removing inverters.
     */
    public function showRemovalForm()
    {
        $inverters = Inverter::where('quantity_in_stock', '>', 0)->get();
        return view('inverters.remove', compact('inverters'));
    }

    /**
     * Store the inverter removal and create transaction.
     */
    public function storeRemoval(Request $request)
    {
        $validated = $request->validate([
            'inverter_id' => 'required|exists:inverters,id',
            'particulars' => 'required|string|max:255',
            'qty' => 'required|integer|min:1',
            'date' => 'required|date',
            'remarks' => 'nullable|string|max:255',
        ]);

        $inverter = Inverter::findOrFail($validated['inverter_id']);

        // Validate that we don't remove more than available
        if ($validated['qty'] > $inverter->quantity_in_stock) {
            return redirect()->back()->withErrors([
                'qty' => 'Cannot remove more than available in stock (' . $inverter->quantity_in_stock . ')'
            ])->withInput();
        }

        // Update inventory
        $inverter->update([
            'quantity_in_stock' => $inverter->quantity_in_stock - $validated['qty']
        ]);

        // Create transaction record
        $transaction = Transaction::create([
            'date' => $validated['date'],
            'reference' => '', // Will be updated below
            'product_type' => 'inverter',
            'particulars' => $validated['particulars'],
            'qty' => -$validated['qty'], // Negative for removal
            'remarks' => $validated['remarks'] ?? 'Inverter removed from stock'
        ]);

        // Generate and update reference with format: 00 + DD + MM + YY + sequence
        $reference = $this->generateReference($transaction->date, $transaction->id);
        $transaction->update(['reference' => $reference]);

        return redirect()->route('inverters.index')->with('success', 'Inverter removed successfully. Transaction reference: ' . $reference);
    }

    /**
     * Generate transaction reference with format: 00 + DD + MM + YY + sequence
     * Example: 0018012601 (00 + 18 day + 01 month + 26 year + 01 sequence)
     */
    private function generateReference($date, $transactionId)
    {
        $dateObj = \Carbon\Carbon::parse($date);
        $day = str_pad($dateObj->day, 2, '0', STR_PAD_LEFT);
        $month = str_pad($dateObj->month, 2, '0', STR_PAD_LEFT);
        $year = str_pad($dateObj->year % 100, 2, '0', STR_PAD_LEFT);
        
        // Count transactions for this date to create sequence number
        $sequence = Transaction::whereDate('date', $date)->count();
        $sequenceStr = str_pad($sequence, 2, '0', STR_PAD_LEFT);
        
        return '00' . $day . $month . $year . $sequenceStr;
    }

    //export data to excel
    public function export(): StreamedResponse
    {
        $inverters = Inverter::orderBy('created_at', 'desc')->get();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // 1. Set Header Row
        $headers = ['Date', 'Product Name/Model', 'Description', 'Specification', 'Balance in Stock', 'Selling Price'];
        $columnIndex = 1;
        foreach ($headers as $header) {
            // We use the static stringFromColumnIndex helper to turn 1 into 'A', 2 into 'B', etc.
            $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnIndex);
            $sheet->setCellValue($columnLetter . '1', $header);
            $columnIndex++;
        }

        // 2. Fill Data
        $rowCount = 2;
        foreach ($inverters as $log) {
            $sheet->setCellValue('A' . $rowCount, $log->created_at->format('d-m-Y H:i'));
            $sheet->setCellValue('B' . $rowCount, $log->product_name. '/' . $log->model);
            $sheet->setCellValue('C' . $rowCount, ucfirst($log->description));
            $sheet->setCellValue('D' . $rowCount, ucfirst($log->power_rating) . 'W/KVA');
            $sheet->setCellValue('E' . $rowCount, $log->quantity_in_stock);
            $sheet->setCellValue('F' . $rowCount, $log->selling_price);
            $rowCount++;
        }

        // 3. Style (Optional: Make headers bold)
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);

        // 4. Stream the download
        $writer = new Xlsx($spreadsheet);
        
        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="inventory_logs_'.now()->format('Y-m-d').'.xlsx"',
                'Cache-Control' => 'max-age=0',
            ]
        );
    }
}
