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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('reference')->unique(); // Transaction reference number
            $table->string('product_type'); // inverter, avr, solar_panel, battery, ups
            $table->string('particulars'); // Description of transaction
            $table->integer('qty'); // Quantity (positive for in, negative for out)
            $table->text('remarks')->nullable();
            $table->timestamps();
            
            $table->index('date');
            $table->index('product_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
