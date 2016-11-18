<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caixa extends Model
{
    protected $table = 'caixa';
    public $timestamps = false;

    /**
     * Turmas relacionadas
     */
    public function movimentacao() {
        return $this->hasMany('App\Movimentacao');
    }
}
