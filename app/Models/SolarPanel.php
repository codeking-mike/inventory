<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolarPanel extends Model
{
    protected $fillable = [
        'product_name',
        'model',
        'wattage',
        'cell_type',
        'efficiency_percentage',
        'quantity_in_stock',
        'qty_in',
        'qty_out',
        'cost_price',
        'selling_price',
        'description',
    ];
}
