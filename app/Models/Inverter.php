<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inverter extends Model
{
    protected $fillable = [
        'product_name',
        'model',
        'power_rating',
        'quantity_in_stock',
        'qty_in',
        'qty_out',
        'cost_price',
        'selling_price',
        'supplier',
        'description',
        'warranty',
    ];
}
