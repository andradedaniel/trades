<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAtivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ativos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('carteira_id')->unsigned();
            $table->foreign('carteira_id')->references('id')->on('carteiras');
            $table->char('codigo',6);
            $table->string('descricao')->nullable();
            $table->timestamps();
//            $table->unique(['codigo','carteira_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ativos');
    }
}
