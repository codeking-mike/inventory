<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TransactionController extends Controller
{
    /**
     * Display the specified transaction.
     */
    public function index(Request $request)
    {
        $type = $request->get('type');

        // base query for listing
        $query = Transaction::orderBy('created_at', 'desc');
        if (in_array($type, ['Added', 'Removed'])) {
            $query->where('transaction_type', $type);
        }

        // clone for statistics before pagination
        $statsQuery = clone $query;

        $transactions = $query->paginate(20)->appends(['type' => $type]);

        // compute summary numbers from statsQuery (same conditions as listing)
        $totalTransactions = $statsQuery->count();
        $itemsAdded = (clone $statsQuery)->where('transaction_type', 'Added')->sum('qty');
        $itemsRemoved = (clone $statsQuery)->where('transaction_type', 'Removed')->sum('qty');

        return view('transactions.index', compact(
            'transactions',
            'type',
            'totalTransactions',
            'itemsAdded',
            'itemsRemoved'
        ));
    }


    public function show($reference)
    {
        $transaction = Transaction::where('reference', $reference)->firstOrFail();
        return view('transactions.show', compact('transaction'));
    }

    
    //export data to excel (accept optional filter by transaction_type)
    public function export(Request $request): StreamedResponse
    {
        $type = $request->get('type');
        $query = Transaction::orderBy('created_at', 'desc');
        if (in_array($type, ['Added', 'Removed'])) {
            $query->where('transaction_type', $type);
        }
        $transactions = $query->get();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // 1. Set Header Row
        $headers = ['Date', 'Reference', 'Product Category', 'Particulars', 'Quantity', 'Remarks'];
        $columnIndex = 1;
        foreach ($headers as $header) {
            // We use the static stringFromColumnIndex helper to turn 1 into 'A', 2 into 'B', etc.
            $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnIndex);
            $sheet->setCellValue($columnLetter . '1', $header);
            $columnIndex++;
        }

        // 2. Fill Data
        $rowCount = 2;
        foreach ($transactions as $log) {
            $sheet->setCellValue('A' . $rowCount, $log->created_at->format('d-m-Y H:i'));
            $sheet->setCellValue('B' . $rowCount, $log->reference);
            $sheet->setCellValue('C' . $rowCount, ucfirst($log->product_type));
            $sheet->setCellValue('D' . $rowCount, ucfirst($log->remarks));
            $sheet->setCellValue('E' . $rowCount, $log->qty);
            $sheet->setCellValue('F' . $rowCount, $log->particulars);
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
