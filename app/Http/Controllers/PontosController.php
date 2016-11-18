<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use App\Ponto;
use App\Usuario;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class PontosController extends Controller {

    public $area;

    public function __construct() {
        $this->middleware('auth');
        $this->area = 'pontos';
        $this->arrayReturn = array('usuarioLogado' => $this->usuarioLogado = Auth::user());

        $this->mapList = array(
            array('nome' => 'Pontos', 'icon' => 'fa-graduation-cap', 'link' => '/' . $this->area)
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $pageTitle = 'Pontos';
        $pontosBusca = Ponto::groupBy('data')->get();
		$pontos = array();

        foreach ($pontosBusca as $ponto) {
            $pontos[$ponto->id] = array(
                'usuario' => Usuario::find($ponto->usuario_id),
                'tipoRegistros' => $ponto->tipo,
                'horaRegistros' => $ponto->hora,
                'dataRegistros' => $ponto->data
            );
        }

        $this->arrayReturn += [
            'pontos' => $pontos,
            'page_title' => $pageTitle,
            'mapList' => $this->mapList
        ];

        return view($this->area . '.index', $this->arrayReturn);
    }

    public function usuario($usuario_id, $data = '') {
        $pageTitle = 'Pontos';
        $data = str_replace('-', '/', $data);

        if ($data !== '') {
            $pontos = Ponto::where(['usuario_id' => $usuario_id, 'data' => $data])->get();
            $usuario = Usuario::find($usuario_id);

            $this->mapList[] = array('nome' => $usuario->nome, 'icon' => 'fa-graduation-cap', 'link' => '/' . $this->area);
            $this->mapList[] = array('nome' => $data, 'icon' => 'fa-graduation-cap', 'link' => '/' . $this->area);

            $this->arrayReturn += [
                'usuario' => $usuario,
                'page_title' => $pageTitle,
                'registros' => $pontos,
                'data' => $data,
                'mapList' => $this->mapList
            ];
        } else {
            $registrosBusca = Ponto::where('usuario_id', $usuario_id)->groupBy('data')->orderBy('id', 'desc')->get();
            $usuario = Usuario::find($usuario_id);

            $this->mapList[] = array('nome' => $usuario->nome, 'icon' => 'fa-graduation-cap', 'link' => '/' . $this->area);

            foreach ($registrosBusca as $registro) {
                $registros[$registro->data] = count(Ponto::where(['usuario_id' => $usuario_id, 'data' => $registro->data])->get());
            }

            $this->arrayReturn += [
                'usuario' => $usuario,
                'page_title' => $pageTitle,
                'registros' => $registros,
                'data' => $data,
                'mapList' => $this->mapList
            ];
        }

        return view($this->area . '.usuario', $this->arrayReturn);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
