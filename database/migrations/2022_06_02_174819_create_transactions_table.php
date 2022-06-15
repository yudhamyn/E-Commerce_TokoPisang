<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->bigInteger('number')->nullable();
            $table->string('purchase_order')->nullable();
            
            $table->unsignedBigInteger('user_address_id');
            $table->foreign('user_address_id')->references('id')->on('user_address');

            $table->tinyInteger('status')->comment('0 = pending, 1 = process, 2 = sent, 3 = received, 4 = closed, 5 = rejected, 6 = canceled');

            $table->bigInteger('total');
            $table->string('waybill')->nullable();
            
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
        Schema::dropIfExists('transactions');
    }
}
