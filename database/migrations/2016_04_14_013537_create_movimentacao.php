<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimentacao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimentacao', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('caixa_id')->unsigned();
            
            $table->foreign('caixa_id')->
                    references('id')->
                    on('caixa');
            
            $table->string('tipo', 45);
            $table->string('valor', 45);
            $table->mediumText('desc')->nullable();
            $table->string('hora', 45);
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
