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
        Schema::create('bling_data', function (Blueprint $table) {
            $table->id();
            $table->string('access_token');
            $table->integer('expires_in');
            $table->string('token_type');
            $table->string('scope');
            $table->string('refresh_token');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bling_data');
    }
};
