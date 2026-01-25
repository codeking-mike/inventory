<?php

namespace App\Http\Controllers;

use App\Models\SolarPanel;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SolarPanelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $solarPanels = SolarPanel::all();
        return view('solar-panels.index', compact('solarPanels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('solar-panels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'model' => 'nullable|string|max:255',
            'wattage' => 'required|numeric|min:0',
            'cell_type' => 'nullable|string|max:255',
            'efficiency_percentage' => 'nullable|numeric|min:0|max:100',
            'quantity_in_stock' => 'required|integer|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'remarks' => 'nullable|string|max:255',
        ]);

        $solarPanel = SolarPanel::create($validated);

        // Create transaction record
        $transaction = Transaction::create([
            'date' => now()->toDateString(),
            'reference' => '', // Will be updated below
            'product_type' => 'solar_panel',
            'particulars' => 'Added ' . $solarPanel->product_name . ' (' . $solarPanel->model . ')',
            'qty' => $solarPanel->quantity_in_stock,
            'remarks' => $request->remarks ?? 'Initial stock added'
        ]);

        // Generate and update reference with format: 000 + date + id
        $reference = $this->generateReference($transaction->date, $transaction->id);
        $transaction->update(['reference' => $reference]);

        return redirect()->route('solar-panels.index')->with('success', 'Solar Panel added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(SolarPanel $solarPanel)
    {
        return view('solar-panels.show', compact('solarPanel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SolarPanel $solarPanel)
    {
        return view('solar-panels.edit', compact('solarPanel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SolarPanel $solarPanel)
    {
        $oldQty = $solarPanel->quantity_in_stock;

        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'model' => 'nullable|string|max:255',
            'wattage' => 'required|numeric|min:0',
            'cell_type' => 'nullable|string|max:255',
            'efficiency_percentage' => 'nullable|numeric|min:0|max:100',
            'quantity_in_stock' => 'required|integer|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'remarks' => 'nullable|string|max:255',
        ]);

        $solarPanel->update($validated);

        // Create transaction record if quantity changed
        $qtyDifference = $solarPanel->quantity_in_stock - $oldQty;
        if ($qtyDifference != 0) {
            $transaction = Transaction::create([
                'date' => now()->toDateString(),
                'reference' => '', // Will be updated below
                'product_type' => 'solar_panel',
                'particulars' => ($qtyDifference > 0 ? 'Stock added: ' : 'Stock removed: ') . $solarPanel->product_name,
                'qty' => $qtyDifference,
                'remarks' => $request->remarks ?? 'Quantity updated from ' . $oldQty . ' to ' . $solarPanel->quantity_in_stock
            ]);

            // Generate and update reference with format: 000 + date + id
            $reference = $this->generateReference($transaction->date, $transaction->id);
            $transaction->update(['reference' => $reference]);
        }

        return redirect()->route('solar-panels.index')->with('success', 'Solar Panel updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SolarPanel $solarPanel)
    {
        $solarPanel->delete();
        return redirect()->route('solar-panels.index')->with('success', 'Solar Panel deleted successfully');
    }

    public function showRemovalForm()
    {
        $solarPanel = SolarPanel::all();
        return view('solar-panels.remove', compact('solarPanel'));
    }

    //remove stock
    public function storeRemoval(Request $request)
    {
        $validated = $request->validate([
            'solar_panel_id' => 'required|exists:solar_panels,id',
            'quantity' => 'required|integer|min:1',
            'remarks' => 'nullable|string|max:255',
        ]);

        $solarPanel = SolarPanel::findOrFail($validated['solar_panel_id']);

        if ($validated['quantity'] > $solarPanel->quantity_in_stock) {
            return redirect()->back()->withErrors(['quantity' => 'Quantity to remove exceeds stock available.'])->withInput();
        }

        // Update stock
        $solarPanel->decrement('quantity_in_stock', $validated['quantity']);

        // Create transaction record
        $transaction = Transaction::create([
            'date' => now()->toDateString(),
            'reference' => '', // Will be updated below
            'product_type' => 'solar_panel',
            'particulars' => 'Removed ' . $validated['quantity'] . ' of ' . $solarPanel->product_name,
            'qty' => -$validated['quantity'],
            'remarks' => $validated['remarks'] ?? 'Stock removal'
        ]);

        // Generate and update reference with format: 000 + date + id
        $reference = $this->generateReference($transaction->date, $transaction->id);
        $transaction->update(['reference' => $reference]);

        return redirect()->route('solar-panels.index')->with('success', 'Solar Panel stock removed successfully');
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
    //export data to excel
    public function export(): StreamedResponse
    {
        $solarPanels = SolarPanel::orderBy('created_at', 'desc')->get();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // 1. Set Header Row
        $headers = ['Date', 'Product Name/Model', 'Wattage/Cell Type', 'Description', 'Balance in Stock', 'Selling Price'];
        $columnIndex = 1;
        foreach ($headers as $header) {
            // We use the static stringFromColumnIndex helper to turn 1 into 'A', 2 into 'B', etc.
            $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnIndex);
            $sheet->setCellValue($columnLetter . '1', $header);
            $columnIndex++;
        }

        // 2. Fill Data
        $rowCount = 2;
        foreach ($solarPanels as $log) {
            $sheet->setCellValue('A' . $rowCount, $log->created_at->format('d-m-Y H:i'));
            $sheet->setCellValue('B' . $rowCount, $log->product_name. '/' . $log->model);
            $sheet->setCellValue('C' . $rowCount, ucfirst($log->wattage) . 'W / ' . ucfirst($log->cell_type));
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
