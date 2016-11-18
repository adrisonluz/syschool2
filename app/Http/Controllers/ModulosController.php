<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Turma;
use App\Usuario;
use App\Curso;
use App\Modulo;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Auth;

class ModulosController extends Controller {

    public $area;

    public function __construct() {
        $this->middleware('auth');
        $this->area = 'modulos';
        $this->arrayReturn = array('usuarioLogado' => $this->usuarioLogado = Auth::user());

        $this->mapList = array(
            array('nome' => 'Modulos', 'icon' => 'fa-file-text-o', 'link' => '/' . $this->area)
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return redirect('turmas');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $pageTitle = 'Modulos - Cadastro';
        $this->mapList[] = array('nome' => 'Cadastro', 'icon' => 'fa-plus', 'link' => '/' . $this->area . '/create');
        $cursos = Curso::all();

        $this->arrayReturn += [
            'page_title' => $pageTitle,
            'mapList' => $this->mapList,
            'cursos' => $cursos
        ];

        return view($this->area . '.cadastro', $this->arrayReturn);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $rules = array(
            'nome' => 'required',
            'curso_id' => 'required'
        );

        $validator = Validator($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect($this->area . '/create')
                            ->withErrors($validator)
                            ->withInput($request->all());
        } else {
            // store
            $curso = new Modulo;
            $curso->nome = $request->get('nome');
            $curso->curso_id = $request->get('curso_id');
            //$curso->criacao = date();
            //$curso->id_agent = $request->get('id_agent');

            $curso->save();

            // redirect
            Session::flash('success', 'Módulo criado com sucesso!');
            return redirect('turmas');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $modulo = Modulo::find($id);
        $turmas = Turma::where(['modulo_id' => $modulo->id, 'lixeira' => null])->get();

        $pageTitle = 'Módulo - Perfil: ' . $modulo->nome;

        $this->arrayReturn += [
            'modulo' => $modulo,
            'turmas' => $turmas,
            'page_title' => $pageTitle,
            'mapList' => $this->mapList
        ];

        return view($this->area . '.perfil', $this->arrayReturn);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Responsea
     */
    public function edit($id) {
        $modulo = Modulo::find($id);
        $cursos = Curso::all();

        $pageTitle = 'Modulo - Editar: ' . $modulo->nome;
        $this->mapList[] = array('nome' => 'Editar', 'icon' => 'fa-edit', 'link' => '/' . $this->area . '/' . $id . '/edit');

        if ($modulo) {
            $this->arrayReturn += [
                'modulo' => $modulo,
                'cursos' => $cursos,
                'page_title' => $pageTitle,
                'mapList' => $this->mapList
            ];

            return view($this->area . '/editar', $this->arrayReturn);
        } else {
            Session::flash('error', 'Módulo não encontrado!');
            return redirect('turmas');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $rules = array(
            'nome' => 'required',
            'curso_id' => 'required'
        );

        $validator = Validator($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect($this->area . '/' . $id . '/edit')
                            ->withErrors($validator)
                            ->withInput($request->all());
        } else {
            // store
            $modulo = Modulo::find($id);
            $modulo->nome = $request->get('nome');
            $modulo->curso_id = $request->get('curso_id');

            $modulo->save();

            // redirect
            Session::flash('success', 'Módulo editado com sucesso!');
            return redirect('turmas');
        }
    }

    public function excluir(Request $request, $id) {
        $modulo = Modulo::find($id);

        // redirect
        Session::flash('excluir', 'Tem certeza que deseja excluir ' . $modulo->nome . '?');
        Session::flash('modulo_id', $modulo->id);
        return redirect('turmas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        Modulo::destroy($id);

        Session::flash('success', 'Módulo excluído com sucesso.');
        return redirect('turmas');
    }

}
