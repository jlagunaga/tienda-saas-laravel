<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations (creacion).
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // creamos la relacion de customer con orders
            $table->foreignId('customer_id')->nullable()->after('store_id')->constrained()->nullOnDelete();

        });
    }

    /**
     * Reverse the migrations(rollback).
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // elimina la relacion FK y la columna customer_id
            $table->dropConstrainedForeignId('customer_id');            
        });
    }
};
