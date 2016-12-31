<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Usuario;
use App\Contrato;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Auth;

class ContratosController extends Controller {

    public $area;

    public function __construct() {
        $this->middleware('auth');
        $this->area = 'contratos';
        $this->arrayReturn = array('usuarioLogado' => $this->usuarioLogado = Auth::user());

        $this->mapList = array(
            array('nome' => 'Contratos', 'icon' => 'fa-file-text-o', 'link' => '/' . $this->area)
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $pageTitle = 'Contratos';

        $contratos = Contrato::where('lixeira', '=', null)->groupBy('usuario_id')->orderBy('versao', 'desc')->get();
        $alunos = Usuario::where(['nivel' => 'aluno', 'lixeira' => null])->get();

        if (Session::has('alert')) {
            $session = Session::get('alert');
        } else {
            $session = '';
        }

        $this->arrayReturn += [
            'contratos' => $contratos,
            'page_title' => $pageTitle,
            'mapList' => $this->mapList,
            'session' => $session
        ];

        return view($this->area . '.index', $this->arrayReturn);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $pageTitle = 'Contratos - Emitir';
        $this->mapList[] = array('nome' => 'Emitir', 'icon' => 'fa-plus', 'link' => '/' . $this->area . '/create');

        $alunos = Usuario::where(['nivel' => 'aluno', 'lixeira' => null])->get();

        $this->arrayReturn += [
            'alunos' => $alunos,
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
            'usuario_id' => 'required',
            'valor_matricula' => 'required',
            'data' => 'required',
            'meses' => 'required',
            'mensalidades' => 'required'
        );

        $validator = Validator($request->all(), $rules);

        if ($validator->fails()) {
            return redirect($this->area . '/create')
                            ->withErrors($validator)
                            ->withInput($request->all());
        } else {
            // store
            $contrato = new Contrato;
            $contrato->usuario_id = $request->get('usuario_id');
            $contrato->valor_matricula = $request->get('valor_matricula');
            $contrato->data = $request->get('data');
            $contrato->meses = $request->get('meses');
            $contrato->mensalidades = $request->get('mensalidades');
            $contrato->criacao = date('d/m/Y');
            $contrato->emissao = date('d/m/Y');

            $contrato->save();

            // redirect
            Session::flash('success', 'Contrato emitido com sucesso!');
            return redirect($this->area);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $turma = Turma::find($id);
        $curso = $turma->curso;
        $professor = $turma->professor;
        $alunos = Matricula::where(['turma_id' => $id])->get();

        $pageTitle = 'Turmas - Perfil: ' . $curso->nome . ' | ' . $professor->nome;

        $this->arrayReturn += [
            'turma' => $turma,
            'curso' => $curso,
            'professor' => $professor,
            'alunos' => $alunos,
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
        $turma = Turma::find($id);

        $professores = Usuario::where(['nivel' => 'aluno_prof', 'lixeira' => null])->get();
        $alunos = Usuario::where(['nivel' => 'aluno', 'lixeira' => null])->get();
        $cursos = Curso::all();

        $pageTitle = 'Usuários - Editar: ' . $turma->curso->nome . ' | ' . $turma->professor->nome;
        $this->mapList[] = array('nome' => 'Editar', 'icon' => 'fa-edit', 'link' => '/' . $this->area . '/' . $id . '/edit');

        if ($turma) {
            $this->arrayReturn += [
                'turma' => $turma,
                'alunos' => $alunos,
                'professores' => $professores,
                'cursos' => $cursos,
                'page_title' => $pageTitle,
                'mapList' => $this->mapList
            ];

            return view($this->area . '/editar', $this->arrayReturn);
        } else {
            Session::flash('error', 'Turma não encontrada!');
            return redirect($this->area);
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
            'professor_id' => 'required',
            'curso_id' => 'required',
            'dias' => 'required',
            'horario' => 'required',
            'vagas' => 'required',
            'valor_mensalidade' => 'required'
        );

        $validator = Validator($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect($this->area . '/' . $id . '/edit')
                            ->withErrors($validator)
                            ->withInput($request->all());
        } else {
            // store
            $turma = Turma::find($id);

            $turma->professor_id = $request->get('professor_id');
            $turma->curso_id = $request->get('curso_id');
            $turma->dias = $request->get('dias');
            $turma->horario = $request->get('horario');
            $turma->vagas = $request->get('vagas');
            $turma->aulas_dadas = $request->get('aulas_dadas');
            $turma->valor_mensalidade = $request->get('valor_mensalidade');
            //$turma->id_agent = $request->get('id_agent');

            $alunos = $request->get('alunos');
            if ($alunos !== null) {
                foreach ($alunos as $value) {

                    $verificaMatricula = Matricula::where(['aluno_id' => $value, 'turma_id' => $id])->get();

                    if (count($verificaMatricula) > 0) {
                        foreach ($verificaMatricula as $matriculaEncontrada) {
                            Matricula::destroy($matriculaEncontrada->id);
                        }
                    }

                    $matricula = new Matricula;
                    $matricula->turma_id = $id;
                    $matricula->aluno_id = $value;
                    $matricula->save();
                }
            }

            $turma->save();

            // redirect
            Session::flash('success', 'Turma editada com sucesso!');
            return redirect($this->area);
        }
    }

    public function excluir(Request $request, $id) {
        $turma = Turma::find($id);

        // redirect
        Session::flash('excluir', 'Tem certeza que deseja excluir ' . $turma->curso->nome . ' | ' . $turma->professor->nome . '?');
        Session::flash('turma_id', $turma->id);
        return redirect($this->area);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        Turma::destroy($id);

        Session::flash('success', 'Turma excluída com sucesso.');
        return redirect($this->area);
    }

}
