<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaixa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caixa', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('caixa_id')->nullable();
            $table->string('data', 45);
            $table->string('hora_abertura', 45);
            $table->string('hora_fechamento', 45)->nullable();
            $table->string('saldo_inicial', 45)->nullable();
            $table->string('saldo_final', 45)->nullable();
            $table->string('total_entradas', 45)->nullable();
            $table->string('total_saidas', 45)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
