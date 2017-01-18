<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model {

    protected $table = 'contratos';
    public $timestamps = false;

    /**
     * Usuário relacionado
     */
    public function usuario() {
        return $this->belongsTo('App\Usuario', 'usuario_id');
    }

    /**
    * Versões
    */
    public function versoes() {
        $versoes = $this->where('usuario_id', '=', $this->usuario_id)->get();
        return $versoes;
    }
}
