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
            // agregamos campos para personalizar datos de tienda
            $table->text('description')->nullable(); // descripocion de la tienda
            $table->string('address')->nullable(); // direccion de la tienda
            $table->string('whatsapp_number',20)->nullable(); // numero de whatsapp
            $table->string('facebook_url')->nullable(); // url de facebook
            $table->string('instagram_url')->nullable(); // url de instagram
            
            // Rutas de imagen 
            $table->string('logo_path')->nullable(); // ruta del logo
            $table->string('banner_path')->nullable(); // ruta del banner
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            //
        });
    }
};
