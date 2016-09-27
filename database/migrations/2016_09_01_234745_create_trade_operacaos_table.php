<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradeOperacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trade_operacaos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('trade_id')->unsigned();
            $table->foreign('trade_id')->references('id')->on('trades');
            $table->enum('tipo', ['buy', 'sell']);
            $table->enum('in_or_out', ['in', 'out']);
            $table->float('preco');
            $table->integer('volume');//->unsigned();
            $table->float('resultado')->nullable();
            $table->float('lucro_prejuizo')->nullable();
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
        Schema::drop('trade_operacaos');
    }
}
