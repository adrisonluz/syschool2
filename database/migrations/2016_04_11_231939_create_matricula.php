<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatricula extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('matriculas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('usuario_id')->unsigned();
            
            $table->foreign('usuario_id')->
                    references('id')->
                    on('usuarios');            
            
            $table->integer('turma_id')->unsigned();
            
            $table->foreign('turma_id')->
                    references('id')->
                    on('turmas');
            
            $table->timestamp('criacao');
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
