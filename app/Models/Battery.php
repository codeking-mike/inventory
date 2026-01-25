<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Battery extends Model
{
    protected $fillable = [
        'product_name',
        'model',
        'capacity',
        'voltage',
        'chemistry',
        'quantity_in_stock',
        'qty_in',
        'qty_out',
        'cost_price',
        'selling_price',
        'description',
    ];
}
