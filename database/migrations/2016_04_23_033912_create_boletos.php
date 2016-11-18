<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoletos extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('boletos', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('usuario_id')->unsigned()->nullable();
            $table->foreign('usuario_id')->
                    references('id')->
                    on('usuarios');

            $table->integer('remessa_retorno_id')->unsigned()->nullable();
            $table->string('valor', 45);
            $table->string('valor_pagto', 45);
            $table->string('data_vencimento', 45);
            $table->string('data_emissao', 45);
            $table->string('data_pagto', 45);
            $table->string('referencia', 45);
            $table->string('competencia', 45);
            $table->string('sequencial', 255);
            $table->string('linha', 255);
            $table->string('status', 45);
            $table->timestamp('lixeira')->nullable();
            $table->string('desconto', 45);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        
    }

}
