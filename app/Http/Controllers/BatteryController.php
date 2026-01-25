<?php

namespace App\Http\Controllers;

use App\Models\Battery;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BatteryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $batteries = Battery::all();
        return view('batteries.index', compact('batteries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('batteries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'model' => 'nullable|string|max:255',
            'capacity' => 'required|numeric|min:0',
            'voltage' => 'required|numeric|min:0',
            'chemistry' => 'nullable|string|max:255',
            'quantity_in_stock' => 'required|integer|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'remarks' => 'nullable|string|max:255',
        ]);

        $battery = Battery::create($validated);

        // Create transaction record
        $transaction = Transaction::create([
            'date' => now()->toDateString(),
            'reference' => '', // Will be updated below
            'product_type' => 'battery',
            'particulars' => 'Added ' . $battery->product_name . ' (' . $battery->model . ')',
            'qty' => $battery->quantity_in_stock,
            'remarks' => $request->remarks ?? 'Initial stock added'
        ]);

        // Generate and update reference with format: 000 + date + id
        $reference = $this->generateReference($transaction->date, $transaction->id);
        $transaction->update(['reference' => $reference]);

        return redirect()->route('batteries.index')->with('success', 'Battery added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Battery $battery)
    {
        return view('batteries.show', compact('battery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Battery $battery)
    {
        return view('batteries.edit', compact('battery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Battery $battery)
    {
        $oldQty = $battery->quantity_in_stock;

        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'model' => 'nullable|string|max:255',
            'capacity' => 'required|numeric|min:0',
            'voltage' => 'required|numeric|min:0',
            'chemistry' => 'nullable|string|max:255',
            'quantity_in_stock' => 'required|integer|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'remarks' => 'nullable|string|max:255',
        ]);

        $battery->update($validated);

        // Create transaction record if quantity changed
        $qtyDifference = $battery->quantity_in_stock - $oldQty;
        if ($qtyDifference != 0) {
            $transaction = Transaction::create([
                'date' => now()->toDateString(),
                'reference' => '', // Will be updated below
                'product_type' => 'battery',
                'particulars' => ($qtyDifference > 0 ? 'Stock added: ' : 'Stock removed: ') . $battery->product_name,
                'qty' => $qtyDifference,
                'remarks' => $request->remarks ?? 'Quantity updated from ' . $oldQty . ' to ' . $battery->quantity_in_stock
            ]);

            // Generate and update reference with format: 000 + date + id
            $reference = $this->generateReference($transaction->date, $transaction->id);
            $transaction->update(['reference' => $reference]);
        }

        return redirect()->route('batteries.index')->with('success', 'Battery updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Battery $battery)
    {
        $battery->delete();
        return redirect()->route('batteries.index')->with('success', 'Battery deleted successfully');
    }

    public function showRemovalForm()
    {
        $batteries = Battery::all();
        return view('batteries.remove', compact('batteries'));
    }

    public function storeRemoval(Request $request)
    {
        $validated = $request->validate([
            'battery_id' => 'required|exists:batteries,id',
            'quantity' => 'required|integer|min:1',
            'remarks' => 'nullable|string|max:255',
        ]);

        $battery = Battery::findOrFail($validated['battery_id']);

        if ($battery->quantity_in_stock < $validated['quantity']) {
            return redirect()->back()->withErrors(['quantity' => 'Insufficient stock to remove the requested quantity.'])->withInput();
        }

        // Update battery stock
        $battery->decrement('quantity_in_stock', $validated['quantity']);

        // Create transaction record
        $transaction = Transaction::create([
            'date' => now()->toDateString(),
            'reference' => '', // Will be updated below
            'product_type' => 'battery',
            'particulars' => 'Removed ' . $validated['quantity'] . ' of ' . $battery->product_name,
            'qty' => -$validated['quantity'],
            'remarks' => $validated['remarks'] ?? 'Stock removal'
        ]);

        // Generate and update reference with format: 000 + date + id
        $reference = $this->generateReference($transaction->date, $transaction->id);
        $transaction->update(['reference' => $reference]);

        return redirect()->route('batteries.index')->with('success', 'Battery stock updated successfully');
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
        $batteries = Battery::orderBy('created_at', 'desc')->get();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // 1. Set Header Row
        $headers = ['Date', 'Product Name/Model', 'Voltage/Capacity', 'Description', 'Balance in Stock', 'Selling Price'];
        $columnIndex = 1;
        foreach ($headers as $header) {
            // We use the static stringFromColumnIndex helper to turn 1 into 'A', 2 into 'B', etc.
            $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnIndex);
            $sheet->setCellValue($columnLetter . '1', $header);
            $columnIndex++;
        }

        // 2. Fill Data
        $rowCount = 2;
        foreach ($batteries as $log) {
            $sheet->setCellValue('A' . $rowCount, $log->created_at->format('d-m-Y H:i'));
            $sheet->setCellValue('B' . $rowCount, $log->product_name. '/' . $log->model);
            $sheet->setCellValue('C' . $rowCount, ucfirst($log->voltage) . 'V / ' . ucfirst($log->capacity) . 'Ah');
            $sheet->setCellValue('D' . $rowCount, ucfirst($log->description));
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
