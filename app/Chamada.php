<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chamada extends Model {

    protected $table = 'chamadas';
    public $timestamps = false;

    /**
     * Aluno
     */
    public function aluno() {
        return $this->belongsTo('App\Usuario', 'usuario_id');
    }

    /**
     * Turma
     */
    public function turma() {
        return $this->belongsTo('App\Turma');
    }

}
