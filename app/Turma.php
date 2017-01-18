<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turma extends Model {

    protected $table = 'turmas';
    public $timestamps = false;

    /**
     * Curso relacionado
     */
    public function curso() {
        return $this->belongsTo('App\Curso', 'curso_id');
    }

    /**
     * Módulo relacionado
     */
    public function modulo() {
        return $this->belongsTo('App\Modulo', 'modulo_id');
    }

    /**
     * Professor relacionado
     */
    public function professor() {
        return $this->hasOne('App\Usuario', 'id', 'professor_id');
    }

    /**
     * Aluno relacionado
     */
    public function alunos() {
        return $this->belongsToMany('App\Usuario', 'matriculas');
    }

    /*
     * Horários
     */

    public function horarios() {
        return $this->hasMany('App\Horario', 'turma_id');
    }

    /**
     * Chamadas na turma
     */
    public function chamadas() {
        return $this->hasMany('App\Chamada');
    }

    /**
     * Pontos na turma
     */
    public function pontos() {
        return $this->hasMany('App\Ponto');
    }

    /**
     * Verifica vagas
     */
    public function lotada($id) {
        $turma = Turma::find($id);
        $matriculas = Matricula::where('turma_id', $id)->get();

        if (count($matriculas) >= $turma->vagas) {
            return true;
        } else {
            return false;
        }
    }

}
