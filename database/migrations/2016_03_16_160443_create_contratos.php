<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContratos extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('contratos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('usuario_id')->unsigned();

            $table->foreign('usuario_id')->
                    references('id')->
                    on('usuarios');

            $table->string('data', 45)->nullable();
            $table->integer('meses');
            $table->integer('mensalidades');
            $table->string('valor_matricula', 255)->nullable();
            $table->string('criacao', 45);
            $table->string('emissao', 45)->nullable();
            $table->string('pagto_matricula', 45)->nullable();
            $table->string('data_modificacao', 45)->nullable();
            $table->integer('logado_id')->nullable();
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
