<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Usuario;
use App\Contrato;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Auth;
use DOMPDF;

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

        //$contratos = Contrato::where('lixeira', '=', null)->orderBy('versao', 'desc')->first();
        $contratos = Contrato::orderBy('versao', 'desc')
                    ->get()
                    ->unique('usuario_id');
        
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
            $contrato->criacao = date('d/m/Y');
            $contrato->emissao = date('d/m/Y');
            
            $usuario = Usuario::find($contrato->usuario_id);
            
            if ($usuario->idade < 18){
                $usuario->nome .= '</strong> responsável <strong>' . $usuario->nome_boleto;
                $usuario->cpf = $usuario->cpf_boleto;
            }
            
            $aulas = '';
            $horarios = '';
            if(count($contrato->usuario->matricula) > 0){
                foreach($contrato->usuario->matricula as $turma){
                    $aulas .= $turma->curso->nome . ', ';
                    
                    foreach($turma->horarios as $horario){
                        $semana = getDiaSemana($horario->dia_semana) . 's ';
                        $semana .= 'das ' . $horario->hora_inicio . ' às ' . $horario->hora_fim . ', ';
                        $horarios .= $semana;
                    }
                }
            }else{
                $aulas = '<b class="text-red">(O ALUNO NÃO ENCONTRA-SE MATRICULADO EM NENHUM CUSRO NO MOMENTO)</b>';
                $horarios = '<b class="text-red">(O ALUNO NÃO ENCONTRA-SE MATRICULADO EM NENHUM CUSRO NO MOMENTO)</b>';
            }
            
            $getVersao = Contrato::where('usuario_id','=',$usuario->id)->get();
            $versao = 1;
            if(count($getVersao) > 0){
                $ultimaVersao = $getVersao->last();
                $versao = $ultimaVersao->versao + 1;
            }
            $contrato->versao = $versao;
                    
            $data = [
                'usuario' => [
                    'nome' => $usuario->nome,
                    'cpf' => $usuario->cpf,
                    'endereco' => $usuario->endereco,
                    'bairro' => $usuario->bairro,
                    'cidade' => $usuario->cidade,
                ],
                'aulas' => $aulas,
                'horarios' => $horarios,
                'valor_mensalidade' => number_format($usuario->mensalidade(), 2, ',', '.'),
                'total_aulas' => $usuario->totalAulas(),
                'matricula' => $request->get('valor_matricula'),
                'meses' => $request->get('meses'),
                'mensalidades' => $request->get('mensalidades'),
                'data' => $request->get('data'),
                'versao' => $versao
            ];
            $contrato->json = json_encode($data);            
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
        $contrato = Contrato::find($id);
        
        if(!$contrato) {
            Session::flash('error', 'Contrato não encontrado.');
            return redirect($this->area);
        }
        
        $pageTitle = 'Contrato ' . $contrato->usuario->nome. ' v. ' . $contrato->versao;
        $data = json_decode($contrato->json);
    
        $this->arrayReturn += [
            'contrato' => $contrato,
            'data' => $data,
            'page_title' => $pageTitle,
            'mapList' => $this->mapList
        ];

        return view($this->area . '.doc', $this->arrayReturn);
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
        $contrato = Contrato::find($id);

        // redirect
        Session::flash('excluir', 'Tem certeza que deseja excluir o contrato de ' . $contrato->usuario->nome . ' v. ' . $contrato->versao . '?');
        Session::flash('contrato_id', $contrato->id);
        return redirect($this->area);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        Contrato::destroy($id);

        Session::flash('success', 'Contrato excluído com sucesso.');
        return redirect($this->area);
    }
    
    public function printContrato($id) {
        $contrato = Contrato::find($id);
        
        if(!$contrato) {
            Session::flash('error', 'Contrato não encontrado.');
            return redirect($this->area);
        }
       
        $data = json_decode($contrato->json);
    
        $this->arrayReturn += [
            'contrato' => $contrato,
            'data' => $data
        ];        
        
        $pdf = new Dompdf();
        $pdf->set_paper('A4', 'landscape');
        $pdf->load_html(view($this->area . '.doc', $this->arrayReturn));
        //$pdf->render();
        //$pdf = App::make('dompdf.wrapper',array());

        $pdf->stream('contrato_' . str_replace('_', ' ', ($contrato->usuario->nome)) . '.pdf');
    }

}
