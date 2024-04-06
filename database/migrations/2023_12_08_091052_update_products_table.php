<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Adiciona colunas do projeto 1 que não existem no projeto 2
            if (!Schema::hasColumn('products', 'category_id')) {
                $table->unsignedBigInteger('category_id')->nullable();
                $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null')->onUpdate('cascade');
            }

            if (!Schema::hasColumn('products', 'status')) {
                $table->boolean('status')->nullable();
            }

            // Continue adicionando as outras colunas conforme necessário

            // Exemplo: Adiciona coluna 'view_home'
            if (!Schema::hasColumn('products', 'view_home')) {
                $table->boolean('view_home')->nullable();
            }

            // Repita o processo para cada coluna que precisa ser adicionada

            // ... Adicione as colunas restantes

        });
    }

    public function down()
    {
        // Se precisar de um rollback, você pode removê-las no método down
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['category_id', 'status', 'view_home', /* ... Outras colunas adicionadas ... */]);
        });
    }
};
