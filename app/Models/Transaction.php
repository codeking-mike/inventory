<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'date',
        'reference',
        'product_type',
        'transaction_type',
        'particulars',
        'qty',
        'waybill_number',
        'remarks',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
