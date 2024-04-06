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
        Schema::create('mercado_livre', function (Blueprint $table) {
            $table->id();
        $table->unsignedBigInteger('user_id');
        $table->string('access_token');
        $table->string('id_ml');
        $table->string('nickname')->nullable();
        $table->string('first_name')->nullable();
        $table->string('last_name')->nullable();
        $table->string('email')->nullable();
        $table->string('address')->nullable();
        $table->string('city')->nullable();
        $table->string('state')->nullable();
        $table->string('zip_code')->nullable();
        $table->string('phone')->nullable();
        $table->string('permalink')->nullable();
        $table->string('refresh_token')->nullable();
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mercado_livre');
    }
};
