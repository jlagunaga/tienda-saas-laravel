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
        Schema::table('stores', function (Blueprint $table) {
            // nuevas columnas de los metodos de pago
            $table->text('payment_instructions')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('bank_cci')->nullable();
            $table->string('bank_holder')->nullable();
            $table->string('yape_qr_path')->nullable();
            $table->string('yape_phone')->nullable();
            $table->string('plin_qr_path')->nullable();
            $table->string('plin_phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            // elimnar las tablas creadas
            $table->dropColumn([
                'payment_instructions',
                'bank_name',
                'bank_account',
                'bank_cci',
                'bank_holder',
                'yape_qr_path',
                'yape_phone',
                'plin_qr_path',
                'plin_phone',
            ]);
        });
    }
};
