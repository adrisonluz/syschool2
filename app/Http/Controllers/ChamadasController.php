<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use App\Chamada;
use App\Turma;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class ChamadasController extends Controller {

    public $area;

    public function __construct() {
        $this->middleware('auth');
        $this->area = 'chamadas';
        $this->arrayReturn = array('usuarioLogado' => $this->usuarioLogado = Auth::user());

        $this->mapList = array(
            array('nome' => 'Chamadas', 'icon' => 'fa-graduation-cap', 'link' => '/' . $this->area)
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $pageTitle = 'Chamadas';
        $chamadasBusca = Chamada::groupBy('data')->groupBy('turma_id')->get();
		$chamadas = array();

        foreach ($chamadasBusca as $chamada) {
            echo $chamada->id;
            $numRegistros = Chamada::where(['turma_id' => $chamada->turma_id, 'data' => $chamada->data])->get();
            $chamadas[$chamada->id] = array(
                'turma' => Turma::find($chamada->turma_id),
                'numRegistros' => count($numRegistros),
                'dataRegistros' => $chamada->data
            );
        }

        $this->arrayReturn += [
            'chamadas' => $chamadas,
            'page_title' => $pageTitle,
            'mapList' => $this->mapList
        ];

        return view($this->area . '.index', $this->arrayReturn);
    }

    public function turma($turma_id, $data = '') {
        $pageTitle = 'Chamadas';
        $data = str_replace('-', '/', $data);

        if ($data !== '') {
            $turmas = Chamada::where(['turma_id' => $turma_id, 'data' => $data])->get();
            $turma = Turma::find($turma_id);

            $this->mapList[] = array('nome' => $turma->curso->nome . ' | ' . $turma->modulo->nome . ' | ' . $turma->professor->nome, 'icon' => 'fa-graduation-cap', 'link' => '/' . $this->area);
            $this->mapList[] = array('nome' => $data, 'icon' => 'fa-graduation-cap', 'link' => '/' . $this->area);

            $this->arrayReturn += [
                'turma' => $turma,
                'page_title' => $pageTitle,
                'registros' => $turmas,
                'data' => $data,
                'mapList' => $this->mapList
            ];
        } else {
            $registrosBusca = Chamada::where('turma_id', $turma_id)->groupBy('data')->orderBy('id', 'desc')->get();
            $turma = Turma::find($turma_id);

            $this->mapList[] = array('nome' => $turma->curso->nome . ' | ' . $turma->modulo->nome . ' | ' . $turma->professor->nome, 'icon' => 'fa-graduation-cap', 'link' => '/' . $this->area);

            foreach ($registrosBusca as $registro) {
                $registros[$registro->data] = count(Chamada::where(['turma_id' => $turma_id, 'data' => $registro->data])->get());
            }

            $this->arrayReturn += [
                'turma' => $turma,
                'page_title' => $pageTitle,
                'registros' => $registros,
                'data' => $data,
                'mapList' => $this->mapList
            ];
        }

        return view($this->area . '.turma', $this->arrayReturn);
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
