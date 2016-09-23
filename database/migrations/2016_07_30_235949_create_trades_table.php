<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trades', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('ativo_id')->unsigned();
            $table->foreign('ativo_id')->references('id')->on('ativos');
            $table->date('data');
            $table->enum('tipo', ['buy', 'sell']);
//            $table->decimal('preco_medio',5,2)->nullable();
            $table->float('preco_medio');
            $table->float('resultado')->nullable();
            $table->float('lucro_prejuizo')->nullable();
            $table->integer('volume')->nullable();//->unsigned()
            $table->integer('volume_aberto')->nullable();//->unsigned()
            $table->boolean('trade_aberto')->default(true);
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
        Schema::drop('trades');
    }
}
