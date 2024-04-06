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
        Schema::create('product_ml', function (Blueprint $table) {
            $table->id();
            $table->string('id_ml');
            $table->unsignedBigInteger('id_conta_ml');
            $table->unsignedBigInteger('product_id');
            $table->string('permalink')->nullable();
            $table->foreign('id_conta_ml')->references('id')->on('mercado_livre');
            $table->foreign('product_id')->references('id')->on('products');
            $table->timestamps(); // Adiciona colunas de timestamp
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_ml');
    }
};
