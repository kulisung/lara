<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTs6membersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ts6members', function (Blueprint $table) {
            $table->string('member_id', 20)->index();
            $table->string('name');
            $table->string('email');
            $table->string('cellphone', 20)->nullable();
            $table->string('birthday', 10)->nullable();
            $table->string('sex', 10)->nullable();
            $table->integer('other_amount')->unsigned();
            $table->string('amount_time')->nullable();
            $table->integer('bonus_point')->unsigned();
            $table->string('member_tag', 50)->nullable();
            $table->text('memo')->nullable();
            $table->string('tel')->nullable();
            $table->string('company')->nullable();
            $table->string('postalcode', 10)->nullable();
            $table->string('address');
            $table->integer('order_count')->unsigned();
            $table->integer('order_amount')->unsigned();
            $table->string('register_date');
            $table->string('register_source')->nullable();
            $table->string('uid', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ts6members');
    }
}
