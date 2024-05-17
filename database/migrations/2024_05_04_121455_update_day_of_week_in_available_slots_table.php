<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('available_slots', function (Blueprint $table) {
            $table->dropColumn('day_of_week'); // Primeiro remova a coluna antiga
        });

        Schema::table('available_slots', function (Blueprint $table) {
            // Agora adicione a nova coluna com os dias atualizados
            $table->enum('day_of_week', ['domingo', 'segunda', 'terça', 'quarta', 'quinta', 'sexta', 'sábado'])->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('available_slots', function (Blueprint $table) {
            $table->dropColumn('day_of_week');
        });

        Schema::table('available_slots', function (Blueprint $table) {
            $table->enum('day_of_week', ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'])->after('id');
        });
    }
};
