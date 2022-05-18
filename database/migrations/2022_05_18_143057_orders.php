<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->timestamps();
            $table->string('status');
            $table->string('delivery_place');
            $table->date('delivery_date')->nullable();
            $table->string('transporter')->default('Chronopost');
            $table->string('transporter_tracking_number')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->float('total_price');
            $table->string('payment_method');
            $table->float('total_tax');
            $table->float('total_discount');
            $table->string('recu');
        });

        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_product');
        Schema::dropIfExists('orders');
    }
};
