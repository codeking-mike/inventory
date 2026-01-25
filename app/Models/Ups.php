<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ups extends Model
{
    protected $fillable = [
        'product_name',
        'model',
        'power_capacity',
        'backup_time',
        'quantity_in_stock',
        'qty_in',
        'qty_out',
        'cost_price',
        'selling_price',
        'description',
    ];
}
