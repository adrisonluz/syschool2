<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model {

    protected $table = 'modulos';
    public $timestamps = false;

    /**
     * Curso relacionado
     */
    public function curso() {
        return $this->belongsTo('App\Curso', 'curso_id');
    }

    /**
     * Turmas relacionadas
     */
    public function turma() {
        return $this->hasMany('App\Turma');
    }

}
