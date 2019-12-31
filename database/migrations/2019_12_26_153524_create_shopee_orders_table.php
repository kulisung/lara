<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopeeOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopee_orders', function (Blueprint $table) {
            $table->string('order_id', 30)->index();
            $table->string('buyer_id');
            $table->integer('order_amount');
            $table->integer('trans_cost');
            $table->integer('total_amount');
            $table->integer('discount');
            $table->string('item_name');
            $table->integer('item_price');
            $table->integer('active_price');
            $table->string('item_id');
            $table->integer('qty');
            $table->string('address');
            $table->string('cellphone');
            $table->string('receiver');
            $table->string('ship_method');
            $table->string('payment_method');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shopee_orders');
    }
}
