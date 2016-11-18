<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model {

    protected $table = 'horarios';
    public $timestamps = false;

    /**
     * Turma relacionada
     */
    public function turma() {
        return $this->belongsTo('App\Turma', 'turma_id');
    }

}
