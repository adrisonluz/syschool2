<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Boleto extends Model {

    protected $table = 'boletos';
    public $timestamps = false;

    /**
     * Usuario referente ao boleto
     */
    public function usuario() {
        return $this->belongsTo('App\Usuario');
    }

    /**
     * Remessa ou retorno que contem o boleto
     */
    public function remessaRetorno() {
        return $this->belongsTo('App\RemessaRetorno');
    }

    public function calculaMensalidade($id) {
        $matriculas = Matricula::where('usuario_id', $id)->get();

        $valores = array();
        foreach ($matriculas as $matricula) {
            $turma = Turma::find($matricula->turma_id);
            $valores[] = array(
                'turma' => $turma->curso->nome . ' | ' . $turma->professor->nome,
                'valor' => $turma->mensalidade
            );
        }

        if (count($valores) > 0) {
            return $valores;
        } else {
            $valores = array('Erro:' => 'Aluno não matriculado.');
            return $valores;
        }
    }

}
