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
            $table->integer('ativo_id')->unsigned();
            $table->date('data');
            $table->float('preco_entrada');
            $table->float('preco_saida')->nullable();
            $table->integer('qtd')->unsigned();
            $table->float('resultado')->nullable();
            $table->decimal('lucro_prejuizo',5,2)->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('ativo_id')->references('id')->on('ativos');
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
