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
        Schema::table('inverters', function (Blueprint $table) {
            $table->decimal('cost_price', 10, 2)->nullable()->change();
            $table->decimal('selling_price', 10, 2)->nullable()->change();
        });

        Schema::table('avrs', function (Blueprint $table) {
            $table->decimal('cost_price', 10, 2)->nullable()->change();
            $table->decimal('selling_price', 10, 2)->nullable()->change();
        });

        Schema::table('solar_panels', function (Blueprint $table) {
            $table->decimal('cost_price', 10, 2)->nullable()->change();
            $table->decimal('selling_price', 10, 2)->nullable()->change();
        });

        Schema::table('batteries', function (Blueprint $table) {
            $table->decimal('cost_price', 10, 2)->nullable()->change();
            $table->decimal('selling_price', 10, 2)->nullable()->change();
        });

        Schema::table('ups', function (Blueprint $table) {
            $table->decimal('cost_price', 10, 2)->nullable()->change();
            $table->decimal('selling_price', 10, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inverters', function (Blueprint $table) {
            $table->decimal('cost_price', 10, 2)->nullable(false)->change();
            $table->decimal('selling_price', 10, 2)->nullable(false)->change();
        });

        Schema::table('avrs', function (Blueprint $table) {
            $table->decimal('cost_price', 10, 2)->nullable(false)->change();
            $table->decimal('selling_price', 10, 2)->nullable(false)->change();
        });

        Schema::table('solar_panels', function (Blueprint $table) {
            $table->decimal('cost_price', 10, 2)->nullable(false)->change();
            $table->decimal('selling_price', 10, 2)->nullable(false)->change();
        });

        Schema::table('batteries', function (Blueprint $table) {
            $table->decimal('cost_price', 10, 2)->nullable(false)->change();
            $table->decimal('selling_price', 10, 2)->nullable(false)->change();
        });

        Schema::table('ups', function (Blueprint $table) {
            $table->decimal('cost_price', 10, 2)->nullable(false)->change();
            $table->decimal('selling_price', 10, 2)->nullable(false)->change();
        });
    }
};
