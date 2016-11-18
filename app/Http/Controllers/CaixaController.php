<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Caixa;
use App\Movimentacao;
use App\Usuario;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Auth;

class CaixaController extends Controller {

    public $area;

    public function __construct() {
        $this->middleware('auth');
        $this->area = 'caixa';
        $this->arrayReturn = array('usuarioLogado' => $this->usuarioLogado = Auth::user());

        $this->mapList = array(
            array('nome' => 'Caixa', 'icon' => 'fa-graduation-cap', 'link' => '/' . $this->area)
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return redirect($this->area . '/extrato');
    }

    public function extrato() {
        $pageTitle = 'Caixa';

        $caixas = Caixa::all();

        if (Session::has('alert')) {
            $session = Session::get('alert');
        } else {
            $session = '';
        }

        $this->arrayReturn += [
            'caixas' => $caixas,
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
        $pageTitle = 'Abrir Caixa';
        $this->mapList[] = array('nome' => 'Abrir', 'icon' => 'fa-plus', 'link' => '/' . $this->area . '/create');

        $caixasHoje = Caixa::where(['data' => date('d/m/Y')])->get();
        $caixaMae = Caixa::where(['data' => date('d/m/Y')])->first();

        $caixaAberto = Caixa::where(['data' => date('d/m/Y'), 'hora_fechamento' => null])->get()->first();

        if (count($caixaAberto) > 0) {
            return redirect('caixa/' . $caixaAberto->id);
        }

        $this->arrayReturn += [
            'caixasHoje' => $caixasHoje,
            'caixaMae' => $caixaMae,
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
            'data' => 'required',
            'hora_abertura' => 'required',
            'saldo_inicial' => 'required',
        );

        $validator = Validator($request->all(), $rules);

        if ($validator->fails()) {
            return redirect($this->area . '/create')
                            ->withErrors($validator)
                            ->withInput($request->all());
        } else {
            // store
            $caixa = new Caixa;
            $caixa->caixa_id = $request->get('caixa_id');
            $caixa->data = $request->get('data');
            $caixa->hora_abertura = $request->get('hora_abertura');
            $caixa->saldo_inicial = $request->get('saldo_inicial');

            $caixa->save();

            // redirect
            Session::flash('success', 'Caixa aberto com sucesso!');
            return redirect($this->area . '/extrato');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $caixa = Caixa::find($id);
        $caixasRelacionados = Caixa::where(['data' => $caixa->data])->get();
        $entradas = Movimentacao::where(['tipo' => 'entrada', 'caixa_id' => $id])->get();
        $saidas = Movimentacao::where(['tipo' => 'saida', 'caixa_id' => $id])->get();
        $alunos = Usuario::where(['nivel' => 'aluno', 'lixeira' => null])->get();

        $saldoParcial = new Movimentacao;
        $saldo = $saldoParcial->getSaldo($caixa->id);

        $pageTitle = 'Caixa - ' . $caixa->data;

        $this->arrayReturn += [
            'caixa' => $caixa,
            'saldo' => number_format($saldo, 2, '.', ''),
            'entradas' => $entradas,
            'caixasRelacionados' => $caixasRelacionados,
            'saidas' => $saidas,
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
        $caixa = Caixa::find($id);

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
            'data' => 'required',
            'hora_abertura' => 'required',
            'saldo_inicial' => 'required',
        );

        $validator = Validator($request->all(), $rules);

        if ($validator->fails()) {
            return redirect($this->area . '/edit/' . $id)
                            ->withErrors($validator)
                            ->withInput($request->all());
        } else {
            // store
            $turma = Caixa::finc($id);
            $turma->hora_fechamento = $request->get('hora_fechamento');
            $turma->saldo_final = $request->get('saldo_final');
            $turma->total_entradas = $request->get('total_entradas');
            $turma->total_saidas = $request->get('total_saidas');

            $turma->save();

            // redirect
            Session::flash('success', 'Caixa fechado com sucesso!');
            return redirect($this->area);
        }
    }

    public function fechar(Request $request, $id) {

        // store
        $caixa = Caixa::find($id);
        $caixa->hora_fechamento = date('H:i');

        $mov = new Movimentacao;
        $caixa->saldo_final = $mov->getSaldo($id);
        $caixa->total_entradas = $mov->getEntradas($id);
        $caixa->total_saidas = $mov->getSaidas($id);

        $caixa->save();

        // redirect
        Session::flash('success', 'Caixa fechado com sucesso!');
        return redirect('caixa/extrato');
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
