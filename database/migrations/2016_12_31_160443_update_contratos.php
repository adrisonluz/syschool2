<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateContratos extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('contratos', function ($table) {
            $table->dropColumn('meses');
            $table->dropColumn('mensalidades');
            $table->dropColumn('valor_matricula');
            $table->dropColumn('pagto_matricula');
            $table->dropColumn('data_modificacao');
            $table->dropColumn('data');
        });

        Schema::table('contratos', function (Blueprint $table) {
            $table->string('json', 255)->nullable();
            $table->string('versao', 45)->nullable();
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
