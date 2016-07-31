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
            $table->integer('ativo_id')->unsigned();
            $table->foreign('ativo_id')->references('id')->on('ativos');
            $table->date('data');
            $table->enum('tipo', ['buy', 'sell']);
            $table->float('preco_entrada');
            $table->float('preco_saida')->nullable();
            $table->integer('volume')->unsigned();
            $table->float('resultado')->nullable();
            $table->decimal('lucro_prejuizo',5,2)->nullable();
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
