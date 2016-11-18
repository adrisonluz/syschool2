<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ponto extends Model {

    protected $table = 'pontos';
    public $timestamps = false;

    /**
     * Usuário
     */
    public function usuario() {
        return $this->belongsTo('App\Usuario', 'usuario_id');
    }

    /*
     * Verifica a existência de um registro anterior
     */

    public function verifica($usuario_id) {
        $verificaHorario = Ponto::where([
                    'data' => date('d/m/Y'),
                    'tipo' => 'entrada',
                    'usuario_id' => $usuario_id
                ])
                ->orderBy('id', 'desc')
                ->get();

        if (count($verificaHorario) > 0) {
            $verificaHorario2 = Ponto::where([
                        'data' => date('d/m/Y'),
                        'tipo' => 'saida',
                        'usuario_id' => $usuario_id
                    ])
                    ->orderBy('id', 'desc')
                    ->get();

            if (count($verificaHorario2) > 0 && strtotime($verificaHorario2[0]->hora) > strtotime($verificaHorario[0]->hora)) {
                return 'entrada';
                die();
            }

            $horaInicial = explode(':', $verificaHorario[0]->hora);
            $horaFinal = explode(':', date('H:i'));

            $horaIni = mktime($horaInicial[0], $horaInicial[1]);
            $horaFim = mktime($horaFinal[0] - 3, $horaFinal[1]);

            $horaDiferenca = $horaFim - $horaIni;
            if (abs($horaDiferenca / 60) > 30) {
                return 'saida';
            } else {
                return false;
            }
        } else {
            return 'entrada';
        }
        die();
    }

}
