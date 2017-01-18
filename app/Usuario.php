<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;

class Usuario extends Authenticatable {

    protected $table = 'usuarios';
    public $timestamps = false;
    protected $fillable = [
        'idade',
        'nome',
        'rg',
        'cpf',
        'nascimento',
        'niver',
        'email',
        'telefone',
        'celular',
        'login',
        'password',
        'foto',
        'endereco',
        'bairro',
        'cidade',
        'cep',
        'nome_pai',
        'cel_pai',
        'nome_mae',
        'cel_mae',
        'nome_outro',
        'cel_outro',
        'vinculo',
        'email_resp',
        'nome_boleto',
        'cpf_boleto',
        'desconto',
        'nome_banco',
        'agencia_banco',
        'conta_banco',
        'emerg_nome',
        'emerg_telefone',
        'problema_saude',
        'alergia',
        'medicamento',
        'observacoes',
        'nivel'
    ];
    protected $hidden = [
        'senha', 'remember_token',
    ];

    /**
     * Contrato do usuário
     */
    public function contrato() {
        return $this->hasOne('App\Contrato');
    }

    /**
     * Professor da turma
     */
    public function turmas() {
        return $this->hasMany('App\Turma', 'professor_id', 'id');
    }

    /**
     * Aluno da turma
     */
    public function matricula() {
        return $this->belongsToMany('App\Turma', 'matriculas');
    }    

    /**
     * Boletos do usuario
     */
    public function boletos() {
        return $this->hasMany('App\Boleto');
    }

    /**
     * Chamadas do usuario
     */
    public function chamadas() {
        return $this->hasMany('App\Chamada');
    }

    /**
     * Pontos do usuario
     */
    public function pontos() {
        return $this->hasMany('App\Ponto');
    }

    /*
     * Busca usuario por email
     */

    public function getUsuarioByEmail($email) {
        $user = new Usuario();
        $emailTeste = self::all();
        foreach ($emailTeste as $key => $value) {
            if ($value->email == $email) {
                return $value;
            }
        }
        return false;
    }

    /*
     * Trata e salva imagem de perfil
     */

    public function setImagemFoto($imagemCod, $nomeArquivo) {
        $imagem = str_replace('data:image/png;base64,', '', $imagemCod);
        $imgReturn = base64_decode($imagem);

        if (Storage::disk('perfil')->put($nomeArquivo, $imgReturn, 'public')) {
            return true;
        }
    }
    
    /**
    * Calcula mensalidade total do aluno
    */
    public function mensalidade() {
        $matriculas = Matricula::where('usuario_id', $this->id)->get();

        $total = 0;
        foreach ($matriculas as $matricula) {
            $turma = Turma::find($matricula->turma_id);
            $total = ($total + $turma->mensalidade);
        }

        return $total;
    }
    
    /**
    * Total de aulas 
    */
    public function totalAulas() {
        $matriculas = Matricula::where('usuario_id', $this->id)->get();

        $total = 0;
        foreach ($matriculas as $matricula) {
            $turma = Turma::find($matricula->turma_id);
            $total = ($total + ($turma->curso->qtd_aulas - $turma->aulas_dadas));
        }

        return $total;
    }
}
