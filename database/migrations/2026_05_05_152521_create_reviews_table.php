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
        Schema::create('reviews', function (Blueprint $table) {
            // campos de la tabla reviews
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('rating');// numeros del 1 -5 
            $table->text('comment')->nullable();// comentario opcional
            $table->boolean('is_visible')->default(true);// visible por defecto, el vendedor decide ocultarlo
            $table->timestamps();

            // regla de negocio: un customer solo puede dejar una review por product
            $table->unique(['product_id', 'customer_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
