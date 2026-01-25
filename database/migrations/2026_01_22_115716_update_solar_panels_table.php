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
        Schema::table('solar_panels', function (Blueprint $table) {
        // 1. Delete fields
            $table->dropColumn(['supplier', 'warranty']);

            // 2. Change existing fields to nullable
            // Note: You must ensure the field types match what they currently are
            $table->decimal('selling_price', 10, 2)->nullable()->change();
            $table->decimal('cost_price', 10, 2)->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solar_panels', function (Blueprint $table) {
        // Reverse the changes if you rollback
            $table->string('supplier');
            $table->string('warranty');
            $table->string('selling_price')->nullable(false)->change();
            $table->decimal('cost_price', 10, 2)->nullable(false)->change();
        });
    }
};
