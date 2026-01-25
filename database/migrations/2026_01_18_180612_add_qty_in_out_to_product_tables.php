<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = ['inverters', 'avrs', 'solar_panels', 'batteries', 'ups'];
        
        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->integer('qty_in')->default(0)->after('quantity_in_stock');
                $table->integer('qty_out')->default(0)->after('qty_in');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['inverters', 'avrs', 'solar_panels', 'batteries', 'ups'];
        
        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn(['qty_in', 'qty_out']);
            });
        }
    }
};
