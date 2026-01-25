<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Transaction::all();
    }

    // Define the headers in the Excel file
    public function headings(): array
    {
        return [
            'Date',
            'Reference',
            'Category',
            'Particulars',
            'Quantity',
            'Remarks'
        ];
    }

    // Map the data to the columns
    public function map($transaction): array
    {
        return [
            $transaction->created_at->format('d-m-Y H:i'),
            $transaction->reference,
            $transaction->product_type,
            $transaction->remarks,
            $transaction->qty,
            $transaction->particulars,
        ];
    }
}