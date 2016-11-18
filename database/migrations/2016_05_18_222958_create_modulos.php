<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulos extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('modulos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 255);
            $table->integer('curso_id');
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
