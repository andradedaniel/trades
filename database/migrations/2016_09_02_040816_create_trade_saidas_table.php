<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradeSaidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trade_saidas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('trade_id')->unsigned();
            $table->foreign('trade_id')->references('id')->on('trades');
            $table->float('preco');
            $table->integer('volume')->unsigned();
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
        Schema::drop('trade_saidas');
    }
}
