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
            //etiquetas para activar notificaciones de pedidos
            $table->string('contact_email')->nullable(); //correo por defecto para recibir notificaciones
            $table->boolean('notify_new_order')->default(true); //notificar nuevos pedidos
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            // Eliminamos ambas columnas si revertimos la migración
            $table->dropColumn(['contact_email', 'notify_new_order']);
        });
    }
};
