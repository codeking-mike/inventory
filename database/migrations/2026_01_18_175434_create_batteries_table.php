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
        Schema::create('batteries', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('model')->nullable();
            $table->decimal('capacity', 10, 2); // in Ah (Ampere-hours)
            $table->decimal('voltage', 5, 2); // in volts
            $table->string('chemistry')->nullable(); // Lithium, Lead-acid, etc.
            $table->integer('quantity_in_stock')->default(0);
            $table->decimal('cost_price', 10, 2);
            $table->decimal('selling_price', 10, 2);
            $table->string('supplier')->nullable();
            $table->text('description')->nullable();
            $table->string('warranty')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batteries');
    }
};
