<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Turma;
use App\Usuario;
use App\Curso;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Auth;

class CursosController extends Controller {

    public $area;

    public function __construct() {
        $this->middleware('auth');
        $this->area = 'cursos';
        $this->arrayReturn = array('usuarioLogado' => $this->usuarioLogado = Auth::user());

        $this->mapList = array(
            array('nome' => 'Cursos', 'icon' => 'fa-file-text-o', 'link' => '/' . $this->area)
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
        $pageTitle = 'Cursos - Cadastro';
        $this->mapList[] = array('nome' => 'Cadastro', 'icon' => 'fa-plus', 'link' => '/' . $this->area . '/create');

        $this->arrayReturn += [
            'page_title' => $pageTitle,
            'mapList' => $this->mapList
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
            'qtd_aulas' => 'required'
        );

        $validator = Validator($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect($this->area . '/create')
                            ->withErrors($validator)
                            ->withInput($request->all());
        } else {
            // store
            $curso = new Curso;
            $curso->nome = $request->get('nome');
            $curso->qtd_aulas = $request->get('qtd_aulas');
            //$curso->criacao = date();
            //$curso->id_agent = $request->get('id_agent');

            $curso->save();

            // redirect
            Session::flash('success', 'Curso criado com sucesso!');
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
        $curso = Curso::find($id);

        $pageTitle = 'Curso - Perfil: ' . $curso->nome;

        $this->arrayReturn += [
            'curso' => $curso,
            'page_title' => $pageTitle,
            'mapList' => $this->mapList
        ];

        return view($this->area . '.perfil', $this->arrayReturn);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $curso = Curso::find($id);

        $pageTitle = 'Cursos - Editar: ' . $curso->nome;
        $this->mapList[] = array('nome' => 'Editar', 'icon' => 'fa-edit', 'link' => '/' . $this->area . '/' . $id . '/edit');

        if ($curso) {
            $this->arrayReturn += [
                'curso' => $curso,
                'page_title' => $pageTitle,
                'mapList' => $this->mapList
            ];

            return view($this->area . '/editar', $this->arrayReturn);
        } else {
            Session::flash('error', 'Curso não encontrado!');
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
            'qtd_aulas' => 'required'
        );

        $validator = Validator($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect($this->area . '/' . $id . '/edit')
                            ->withErrors($validator)
                            ->withInput($request->all());
        } else {
            // store
            $curso = Curso::find($id);
            $curso->nome = $request->get('nome');
            $curso->qtd_aulas = $request->get('qtd_aulas');

            $curso->save();

            // redirect
            Session::flash('success', 'Curso editado com sucesso!');
            return redirect('turmas');
        }
    }

    public function excluir(Request $request, $id) {
        $curso = Curso::find($id);

        // redirect
        Session::flash('excluir', 'Tem certeza que deseja excluir ' . $curso->nome . '?');
        Session::flash('curso_id', $curso->id);
        return redirect('turmas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        Curso::destroy($id);

        Session::flash('success', 'Curso excluído com sucesso.');
        return redirect('turmas');
    }

}
