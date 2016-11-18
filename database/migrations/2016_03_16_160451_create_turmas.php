<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTurmas extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('turmas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('professor_id');

            $table->integer('curso_id');
            $table->integer('modulo_id');

            $table->integer('vagas')->nullable();
            $table->integer('dias');
            $table->string('horario', 255)->nullable();
            $table->integer('aulas_dadas');
            $table->string('mensalidade', 255)->nullable();
            $table->integer('agent_id')->nullable();
            $table->timestamp('criacao');
            $table->timestamp('modificacao');
            $table->timestamp('lixeira')->nullable();
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
