<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemessaRetorno extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('remessasretornos', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('data_geracao');
            $table->timestamp('data_gravacao');
            $table->string('tipo', 45);
            $table->string('caminho', 255);
            $table->string('status', 45);
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
