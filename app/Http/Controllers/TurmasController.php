<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Turma;
use App\Usuario;
use App\Curso;
use App\Modulo;
use App\Matricula;
use App\Boleto;
use App\Horario;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Auth;

class TurmasController extends Controller {

    public $area;

    public function __construct() {
        $this->middleware('auth');
        $this->area = 'turmas';
        $this->arrayReturn = array('usuarioLogado' => $this->usuarioLogado = Auth::user());

        $this->mapList = array(
            array('nome' => 'Turmas', 'icon' => 'fa-graduation-cap', 'link' => '/' . $this->area)
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $pageTitle = 'Turmas';

        $turmas = Turma::all();
        $cursos = Curso::all();
        $modulos = Modulo::all();

        if (Session::has('alert')) {
            $session = Session::get('alert');
        } else {
            $session = '';
        }

        $this->arrayReturn += [
            'turmas' => $turmas,
            'cursos' => $cursos,
            'modulos' => $modulos,
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
        $pageTitle = 'Turmas - Cadastro';
        $this->mapList[] = array('nome' => 'Cadastro', 'icon' => 'fa-plus', 'link' => '/' . $this->area . '/create');

        $professores = Usuario::where(['nivel' => 'aluno_prof', 'lixeira' => null])->get();
        $alunos = Usuario::where(['nivel' => 'aluno', 'lixeira' => null])->get();
        $cursos = Curso::all();
        $modulos = Modulo::all();

        $this->arrayReturn += [
            'alunos' => $alunos,
            'professores' => $professores,
            'cursos' => $cursos,
            'modulos' => $modulos,
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
            'professor_id' => 'required',
            'curso_id' => 'required',
            'modulo_id' => 'required',
            'vagas' => 'required',
            'mensalidade' => 'required'
        );

        $validator = Validator($request->all(), $rules);

        if ($validator->fails()) {
            return redirect($this->area . '/create')
                            ->withErrors($validator)
                            ->withInput($request->all());
        } else {
            // store
            $turma = new Turma;
            $turma->professor_id = $request->get('professor_id');
            $turma->curso_id = $request->get('curso_id');
            $turma->modulo_id = $request->get('modulo_id');
            $turma->horario = $request->get('horario');
            $turma->vagas = $request->get('vagas');
            $turma->aulas_dadas = $request->get('aulas_dadas');
            $turma->mensalidade = $request->get('mensalidade');
            //$turma->id_agent = $request->get('id_agent');

            $turma->save();

            $hor_dia_semana = $request->get('dia_semana');
            $hor_hora_inicio = $request->get('hora_inicio');
            $hor_hora_fim = $request->get('hora_fim');
            $numHor = 0;

            foreach ($hor_dia_semana as $semana) {
                if ($semana !== '') {
                    $horario = new Horario;
                    $horario->turma_id = $turma->id;
                    $horario->dia_semana = $semana;
                    $horario->hora_inicio = $hor_hora_inicio[$numHor];
                    $horario->hora_fim = $hor_hora_fim[$numHor];

                    $horario->save();
                }
                $numHor++;
            }

            $alunos = $request->get('alunos');
            if ($alunos !== null) {
                foreach ($alunos as $value) {
                    $matricula = new Matricula;
                    $matricula->turma_id = $turma->id;
                    $matricula->usuario_id = $value;
                    $matricula->save();
                }
            }

            // redirect
            Session::flash('success', 'Turma criada com sucesso!');
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
        $pageTitle = 'Turmas - Perfil: ' .  $turma->curso->nome . ' | ' . $turma->modulo->nome . ' | ' . $turma->professor->nome;

        $this->arrayReturn += [
            'turma' => $turma,
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
        $modulos = Modulo::all();

        $alunosMatriculados = Matricula::select('usuario_id')->where('turma_id', $id)->get();

        if (count($alunosMatriculados) > 0) {
            foreach ($alunosMatriculados as $key => $aluno_id) {
                $matriculas[] = $aluno_id->usuario_id;
            }
        } else {
            $matriculas = array();
        }

        $turmaCheia = $turma->lotada($id);
        $horarios = Horario::where(['turma_id' => $id])->get()->toArray();

        $pageTitle = 'Usuários - Editar: ' . $turma->curso->nome . ' | ' . $turma->professor->nome;
        $this->mapList[] = array('nome' => 'Editar', 'icon' => 'fa-edit', 'link' => '/' . $this->area . '/' . $id . '/edit');

        if ($turma) {
            $this->arrayReturn += [
                'turma' => $turma,
                'alunos' => $alunos,
                'modulos' => $modulos,
                'matriculas' => $matriculas,
                'turmaCheia' => $turmaCheia,
                'professores' => $professores,
                'cursos' => $cursos,
                'horarios' => $horarios,
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
            'modulo_id' => 'required',
            'vagas' => 'required',
            'mensalidade' => 'required'
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
            $turma->modulo_id = $request->get('modulo_id');
            $turma->dias = $request->get('dias');
            $turma->horario = $request->get('horario');
            $turma->vagas = $request->get('vagas');
            $turma->aulas_dadas = $request->get('aulas_dadas');
            $turma->mensalidade = $request->get('mensalidade');
            //$turma->id_agent = $request->get('id_agent');

            $alunos = $request->get('alunos');
            if ($alunos !== null) {
                foreach ($alunos as $value) {

                    $verificaMatricula = Matricula::where(['usuario_id' => $value, 'turma_id' => $id])->get();

                    if (count($verificaMatricula) > 0) {
                        foreach ($verificaMatricula as $matriculaEncontrada) {
                            Matricula::destroy($matriculaEncontrada->id);
                        }
                    }

                    $matricula = new Matricula;
                    $matricula->turma_id = $id;
                    $matricula->usuario_id = $value;
                    $matricula->save();
                }
            }

            $turma->save();

            $hor_dia_semana = $request->get('dia_semana');
            $hor_hora_inicio = $request->get('hora_inicio');
            $hor_hora_fim = $request->get('hora_fim');
            $numHor = 0;

            $verificaHorarios = Horario::where(['turma_id' => $turma->id])->get();
            if (count($verificaHorarios) > 0) {
                foreach ($verificaHorarios as $horario) {
                    Horario::destroy($horario->id);
                }
            }

            foreach ($hor_dia_semana as $semana) {
                if ($semana !== '') {
                    $horario = new Horario;
                    $horario->turma_id = $turma->id;
                    $horario->dia_semana = $semana;
                    $horario->hora_inicio = $hor_hora_inicio[$numHor];
                    $horario->hora_fim = $hor_hora_fim[$numHor];

                    $horario->save();
                }
                $numHor++;
            }


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

    public function emitirBoletos($turma_id = '') {
        $turma_id = (!empty($_POST['turma_id']) ? $_POST['turma_id'] : $turma_id);
        $alunos = Matricula::where('turma_id', $turma_id)->get();

        foreach ($alunos as $aluno) {
            $boletoAluno = Boleto::where(['usuario_id' => $aluno->usuario_id, 'competencia' => date('m/Y')])->get();

            if (count($boletoAluno) > 0) {
                $result[$boletoAluno[0]->id] = array(
                    'nome' => $boletoAluno[0]->usuario->nome,
                    'valor' => $boletoAluno[0]->valor,
                    'status' => $boletoAluno[0]->status
                );
            } else {
                $usuario = Usuario::find($aluno->usuario_id);

                $boleto = new Boleto;
                $boleto->usuario_id = $aluno->usuario_id;
                $boleto->data_vencimento = date('d/m/Y', strtotime(date('Y-m-d') . '+5 day'));
                $boleto->data_emissao = date('d/m/Y');
                $boleto->referencia = 'mensalidade';
                $boleto->competencia = date('m/Y');
                $seq = date('dmyHi') . $usuario->id;
                $boleto->sequencial = $seq;
                $boleto->linha = $seq;
                $boleto->status = 'aberto';

                $matriculas = Matricula::where('usuario_id', $aluno->usuario_id)->get()->toArray();

                foreach ($matriculas as $matricula) {
                    $mensalidades[] = Turma::select('mensalidade')->find($matricula['turma_id'])->toArray();
                }

                $valor = 0;
                foreach ($mensalidades as $mensalidade => $valorMensal) {
                    $valores[] = $valorMensal['mensalidade'];
                    $valor = $valor + $valorMensal['mensalidade'];
                }

                switch ($usuario->desconto) {
                    case 'familia':
                    case 'fidelidade':
                        $descontoMensalidade = ((int) min($valores)) * 0.40;
                        $boleto->valor = ((int) $valor) - $descontoMensalidade;
                        $boleto->desconto = $descontoMensalidade;
                        break;
                    case 'isento':
                        $boleto->valor = '00.00';
                        break;
                    case 'auxilio':
                        $boleto->valor = '75.00';
                        break;
                    default:
                        $boleto->valor = $valor;
                        break;
                }

                $boleto->save();

                $result[$boleto->id] = array(
                    'nome' => $usuario->nome,
                    'valor' => $boleto->valor,
                    'status' => 'emitido'
                );

                unset($valor);
            }
        }

        return json_encode($result);
    }

    public function consultaByAluno() {
        $alunoId = (!empty($_POST['aluno_id']) ? $_POST['aluno_id'] : $_GET['aluno_id']);
        $matriculas = Matricula::where('usuario_id', $alunoId)->groupBy('turma_id')->get();
        
        $result = array();
        foreach($matriculas as $matricula){
            $turma = Turma::find($matricula->turma_id);
            $result[$matricula->turma_id] = $turma->curso->nome . ' | ' . $turma->modulo->nome . ' | ' . $turma->professor->nome;
        }
        
        echo json_encode($result);
        die();
    }
}
