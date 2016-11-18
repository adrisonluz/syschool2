<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Usuario;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Auth;

class QRcodeController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->area = 'qrcode';
        $this->arrayReturn = array('usuarioLogado' => $this->usuarioLogado = Auth::user());

        $this->mapList = array(
            array('nome' => 'QRCode', 'icon' => '', 'link' => '/' . $this->area)
        );
    }

    public function setQRUsuario($usuario_id) {
        $usuario = Usuario::find($usuario_id);

        $codigo = '{"nome":"' . $usuario->nome
                . '","matricula":"' . $usuario->id
                . '","nascimento":"' . $usuario->nascimento
                . '","boleto_nome":"' . $usuario->boleto_nome
                . '","boleto_cpf":"' . $usuario->boleto_cpf . '"}';

        //QrCode::format('png');
        QrCode::size(800);
        QrCode::generate($codigo, '../storage/app/qrcode/' . $usuario->nome . '.png');

        dd(QrCode::mergeString(Storage::disk('qrcode')->get($usuario->nome . '.png'), $codigo));
    }

}
