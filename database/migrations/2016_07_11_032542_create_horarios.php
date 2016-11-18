<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHorarios extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('horarios', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('turma_id')->unsigned();
            $table->foreign('turma_id')->
                    references('id')->
                    on('turmas');

            $table->string('dia_semana', 45);
            $table->string('hora_inicio', 45);
            $table->string('hora_fim', 45);
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
