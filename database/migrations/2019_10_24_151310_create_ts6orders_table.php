<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTs6ordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ts6orders', function (Blueprint $table) {
            $table->string('order_time');
            $table->string('order_id', 20)->index();
            $table->string('status');
            $table->string('memo');
            $table->string('name');
            $table->string('email');
            $table->string('receiver');
            $table->string('phone');
            $table->string('address');
            $table->string('item_name');
            $table->string('item_style')->nullable();
            $table->string('item_id');
            $table->integer('price')->unsigned();
            $table->integer('quantity')->unsigned();
            $table->integer('amount')->unsigned();
            $table->string('activity')->nullable();
            $table->integer('activity_amount')->unsigned();
            $table->string('offer_name');
            $table->string('offer_sn');
            $table->integer('offer_amount')->unsigned();
            $table->integer('bonus_discount')->unsigned();
            $table->integer('discount')->nullable();
            $table->integer('discount_amount')->nullable();
            $table->integer('fare');
            $table->integer('total_amount');
            $table->string('payment_method');
            $table->string('payment_status');
            $table->string('ship_method');
            $table->string('ship_status');
            $table->string('return_status');
            $table->string('invoice_type');
            $table->string('invoice_title')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('tax_id')->nullable();
            $table->string('other_info')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ts6orders');
    }
}
