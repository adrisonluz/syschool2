<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PontoCreate extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('pontos', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('usuario_id')->unsigned()->nullable();
            $table->foreign('usuario_id')->
                    references('id')->
                    on('usuarios');

            $table->integer('turma_id')->unsigned()->nullable();
            $table->foreign('turma_id')->
                    references('id')->
                    on('turmas');

            $table->string('data', 45);
            $table->string('hora', 45);
            $table->string('tipo', 45);
            $table->mediumText('observacoes')->nullable();
            $table->timestamp('criacao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }

}
