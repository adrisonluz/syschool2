<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuarios')->insert([
            'idade' => 26,
            'nome' => 'Teste',
            'rg' => '',
            'cpf' => '000.000.000-00',
            'nascimento' => '00/00/0000',
            'niver' => '00/00',
            'email' => 'teste@teste.com',
            'telefone' => '(00) 0000-0000',
            'celular' => '(00) 0000-0000',
            'login' => 'teste',
            'password' => bcrypt('123456'),
            'foto' => '',
            'endereco' => '',
            'bairro' => '',
            'cidade' => '',
            'cep' => '00000-000',
            'nome_pai' => '',
            'cel_pai' => '(00) 0000-0000',
            'nome_mae' => '',
            'cel_mae' => '(00) 0000-0000',
            'nome_outro' => '',
            'cel_outro' => '(00) 0000-0000',
            'vinculo' => '',
            'email_resp' => 'teste@teste.com',
            'nome_boleto' => 'Teste',
            'cpf_boleto' => '000.000.000-00',
            'desconto' => 'nenhum',
            'nome_banco' => 'Teste',
            'agencia_banco' => '0000',
            'conta_banco' => '00000000-0',
            'emerg_nome' => '',
            'emerg_telefone' => '(00) 0000-0000',
            'problema_saude' => 'não',
            'alergia' => 'não',
            'medicamento' => 'não',
            'observacoes' => '',
            'nivel' => 'aluno'
        ]);
    }
}
