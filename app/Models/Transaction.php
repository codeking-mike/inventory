<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'date',
        'reference',
        'product_type',
        'particulars',
        'qty',
        'remarks',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
