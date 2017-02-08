<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model {

    protected $table = 'agenda';
    public $timestamps = false;

    /**
     * Usuário relacionado
     */
    public function usuario() {
        return $this->belongsTo('App\Usuario', 'usuario_id');
    }
}
