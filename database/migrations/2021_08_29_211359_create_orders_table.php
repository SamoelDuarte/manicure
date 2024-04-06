<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('ref_id')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_address_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('payment_method_id')->nullable()->constrained()->nullOnDelete();
            $table->string('discount_code')->nullable();
            $table->double('discount')->default(0.00);
            $table->double('subtotal')->default(0.00);
            $table->double('shipping')->default(0.00);
            $table->double('tax')->default(0.00);
            $table->double('total')->default(0.00);
            $table->string('name_shipping')->nullable();
            $table->string('number_shipping')->nullable();
            $table->string('model_shipping')->nullable();
            $table->string('document_shipping')->nullable();
            $table->string('reference_shipping')->nullable();
            $table->string('code_shipping')->nullable();
            $table->string('number_label_shipping')->nullable();
            $table->string('currency')->default('BRL');
            $table->unsignedTinyInteger('order_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
