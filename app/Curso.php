<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'cursos';
    public $timestamps = false;

    /**
     * Turmas relacionadas
     */
    public function turma() {
        return $this->hasMany('App\Turma');
    }
}
