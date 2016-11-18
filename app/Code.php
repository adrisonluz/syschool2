<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Usuario;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class Code extends Model {

    public function setQRUsuario($usuario_id) {
        //$usuario = Usuario::find($usuario_id);

        /*
         * $codigo = '{"nome":"' . $usuario->nome
          . '","matricula":"' . $usuario->id
          . '","nascimento":"' . $usuario->nascimento
          . '","boleto_nome":"' . $usuario->boleto_nome
          . '","boleto_cpf":"' . $usuario->boleto_cpf . '"}';
         */

        $url = 'http://sistema.escoladancaalinerosa.com.br/acessos/entrada/' . $usuario_id;
        //$url = 'http://localhost/alinerosa/public/acessos/entrada/' . $usuario_id;
        
        //QrCode::render();
        QrCode::format('png');
        QrCode::size(600);
        QrCode::margin(1);
        QrCode::generate($url, 'qrcode/perfil_' . $usuario_id . '.png');
    }

}
