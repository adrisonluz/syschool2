<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idade');
            $table->string('nome', 255);
            $table->string('rg', 255)->nullable();
            $table->string('cpf', 255)->nullable();
            $table->date('nascimento');
            $table->string('niver', 45);
            $table->string('email', 255)->nullable();
            $table->string('telefone', 255)->nullable();
            $table->string('celular', 255)->nullable();
            $table->string('login', 255)->nullable();
            $table->string('password', 255)->nullable();
            $table->string('foto', 255)->nullable();
            $table->string('endereco', 255);
            $table->string('bairro', 255);
            $table->string('cidade', 255);
            $table->string('cep', 255)->nullable();
            $table->string('nome_pai', 255)->nullable();
            $table->string('cel_pai', 255)->nullable();
            $table->string('nome_mae', 255)->nullable();
            $table->string('cel_mae', 255)->nullable();
            $table->string('nome_outro', 255)->nullable();
            $table->string('cel_outro', 255)->nullable();
            $table->string('vinculo', 255)->nullable();
            $table->string('email_resp', 255)->nullable();
            $table->string('nome_boleto', 255);
            $table->string('cpf_boleto', 255);
            $table->string('desconto', 45)->nullable();
            $table->string('nome_banco', 255)->nullable();
            $table->string('agencia_banco', 255)->nullable();
            $table->string('conta_banco', 255)->nullable();
            $table->string('emerg_nome', 255)->nullable();
            $table->string('emerg_telefone', 255)->nullable();
            $table->mediumText('problema_saude')->nullable();
            $table->mediumText('alergia')->nullable();
            $table->mediumText('medicamento')->nullable();
            $table->mediumText('observacoes')->nullable();
            $table->string('nivel', 45);
            $table->timestamp('lixeira')->nullable();
            $table->string('remember_token', 150)->nullable();
            $table->integer('agent_id')->nullable();
            $table->timestamp('criacao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('usuarios');
    }

}
