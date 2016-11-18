<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Movimentacao;
use App\Caixa;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Auth;

class MovimentacaoController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->area = 'movimentacao';
        $this->arrayReturn = array('usuarioLogado' => $this->usuarioLogado = Auth::user());

        $this->mapList = array(
            array('nome' => 'Movimentação', 'icon' => '', 'link' => '/' . $this->area)
        );
    }

    public function entrada(Request $request) {
        $rules = array(
            'valor' => 'required'
        );

        $validator = Validator($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('caixa/' . $request->get('caixa_id'))
                            ->withErrors($validator)
                            ->withInput($request->all());
        } else {
            // store
            $movimentacao = new Movimentacao;
            $movimentacao->valor = $request->get('valor');
            $movimentacao->tipo = 'entrada';
            $movimentacao->caixa_id = $request->get('caixa_id');
            $movimentacao->hora = date('H:i');

            $valSelect = $request->get('desc_select');
            $valTextarea = $request->get('desc_textarea');
            $movimentacao->desc = ($valSelect == 'change' ? $valTextarea : $valSelect);

            $movimentacao->save();

            // redirect
            return redirect('caixa/' . $request->get('caixa_id'));
        }
    }

    public function saida(Request $request) {
        $rules = array(
            'valor' => 'required'
        );

        $validator = Validator($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('caixa/' . $request->get('caixa_id'))
                            ->withErrors($validator)
                            ->withInput($request->all());
        } else {
            // store
            $movimentacao = new Movimentacao;
            $movimentacao->valor = $request->get('valor');
            $movimentacao->tipo = 'saida';
            $movimentacao->caixa_id = $request->get('caixa_id');
            $movimentacao->hora = date('H:i');

            $valSelect = $request->get('desc_select');
            $valTextarea = $request->get('desc_textarea');
            $movimentacao->desc = ($valSelect == 'change' ? $valTextarea : $valSelect);

            $movimentacao->save();

            // redirect
            return redirect('caixa/' . $request->get('caixa_id'));
        }
    }

}
