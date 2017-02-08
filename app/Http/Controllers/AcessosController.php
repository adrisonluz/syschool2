<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use App\Usuario;
use App\Ponto;
use App\Turma;
use App\Horario;
use App\Chamada;
use Illuminate\Support\Facades\Session;
use DateTime;

class AcessosController extends Controller {

    public function __construct() {
        $this->area = 'acessos';
        $this->arrayReturn = array();

        $this->mapList = array(
            array('nome' => 'Acessos', 'icon' => '', 'link' => '/' . $this->area)
        );
    }

    public function index() {
        $pageTitle = 'Acessos';

        if (Session::has('alert')) {
            $session = Session::get('alert');
        } else {
            $session = '';
        }

        $this->arrayReturn += [
            'page_title' => $pageTitle,
            'mapList' => $this->mapList,
            'session' => $session
        ];

        return view($this->area . '.index', $this->arrayReturn);
    }    
    
    public function entrada($id) {
        $id_usuario = (!empty($_POST['id_usuario']) ? $_POST['id_usuario'] : $id);

        if ($id_usuario !== '') {
            $usuario = Usuario::find($id_usuario);
            $diaSemana = date('D');

            $dados = array(
                'nome' => $usuario->nome,
                'nivel' => ($usuario->nivel == 'aluno' ? 'Aluno' : ($usuario->nivel == 'aluno_prof' ? 'Aluno/Professor' : ($usuario->nivel == 'prof_func' ? 'Proofessor/Funcionário' : ($usuario->nivel == 'sec' ? 'Secretaria' : 'não reconhecido')))),
                'imagem' => ($usuario->foto != '' ? 'perfil/' . $usuario->foto : 'assets/img/default.png')
            );

            switch ($usuario->nivel) {
                case 'aluno':
                    if (count($usuario->matricula) > 0) {
                        foreach ($usuario->matricula as $matricula) {
                            $turmasId[] = $matricula->id;
                        }
                    }

                    $turmas = Horario::where('dia_semana', $diaSemana)->wherein('turma_id', $turmasId)->get();
                    if (count($turmas) > 0) {
                        foreach ($turmas as $turma) {
                            $datatime1 = new DateTime($turma->hora_inicio);
                            $datatime2 = new DateTime(date('H:i'));

                            $data1  = $datatime1->format('H:i');
                            $data2  = $datatime2->format('H:i');

                            $diff = $datatime1->diff($datatime2);
                            $horas = $diff->h + ($diff->days * 24);

                            // Define 15 min como tolerancia
                            if ($diff->i <= 15) {
                                $chamada = new Chamada;
                                $chamada->usuario_id = $id_usuario;
                                $chamada->turma_id = $turma->turma_id;
                                $chamada->data = date('d/m/Y');
                                $chamada->hora = date('H:i');

                                if ($chamada->save()) {
                                    $msg = 'Chamada registrada!';
                                    $tipo = 'sucesso';
                                }
                            } else {
                                $msg = 'Fora do horário de aula!';
                                $tipo = 'erro';
                            }
                        }
                    } else {
                        $msg = 'Aluno não matriculado.';
                        $tipo = 'erro';
                    }

                    break;
                case 'aluno_prof':
                    foreach ($usuario->turmas as $turmaProf) {
                        $turmasId[] = $turmaProf->id;
                    }

                    $turmas = Horario::where('dia_semana', $diaSemana)->wherein('turma_id', $turmasId)->get();
                    if (count($turmas) > 0) {

                        $ponto = New Ponto;
                        $ponto->usuario_id = $usuario->id;
                        $ponto->data = date('d/m/Y');
                        $ponto->hora = date('H:i');

                        $verifica = $ponto->verifica($usuario->id);
                        if ($verifica !== false) {
                            $ponto->tipo = $verifica;
                            $ponto->save();

                            $msg = 'Ponto registrado!';
                            $tipo = 'sucesso';
                        } else {
                            $msg = 'Não foi possível registrar!';
                            $tipo = 'erro';
                        }
                    }
                    break;
                case 'prof_func':
                case 'sec':
                    $ponto = New Ponto;
                    $ponto->usuario_id = $usuario->id;
                    $ponto->data = date('d/m/Y');
                    $ponto->hora = date('H:i');

                    $verifica = $ponto->verifica($usuario->id);
                    if ($verifica !== false) {
                        $ponto->tipo = $verifica;
                        $ponto->save();

                        $msg = 'Ponto registrado!';
                        $tipo = 'sucesso';
                    } else {
                        $msg = 'Não foi possível registrar!';
                        $tipo = 'erro';
                    }
                    break;
            }

            $retorno = array(
                'msg' => $msg,
                'tipo' => $tipo,
                'dados' => $dados
            );

            echo json_encode($retorno);
            die();
        }
    }
    
    public function manual() {
        $this->middleware('auth');
        $this->usuarioLogado = Auth::user();

        if($this->usuarioLogado == null){
                return redirect('/');
        }
        
        $this->arrayReturn += [
            'usuarioLogado' => $this->usuarioLogado
        ];

        $pageTitle = 'Acessos - Manual';
        $this->mapList[] = array('nome' => 'Acessos - Manual', 'icon' => 'fa-plus', 'link' => '/' . $this->area . '/acessos/manual');
        
        if (Session::has('alert')) {
            $session = Session::get('alert');
        } else {
            $session = '';
        }

        $alunos = Usuario::whereIn('nivel', ['aluno','aluno_prof'])->where('lixeira', null)->get();
        $turmas = Turma::all();
        $funcionarios = Usuario::whereIn('nivel', ['aluno_prof','func','sec'])->get();
        
        $this->arrayReturn += [
            'page_title' => $pageTitle,
            'mapList' => $this->mapList,
            'session' => $session,
            'alunos' => $alunos,
            'turmas' => $turmas,
            'funcionarios' => $funcionarios
        ];

        return view($this->area . '.manual', $this->arrayReturn);
    }
    
    public function manualInserir(Request $request) {
		$this->middleware('auth');
        $this->usuarioLogado = Auth::user();

		if($this->usuarioLogado == null){
			return redirect('/');
		}

        $tipo = $request->get('tipo');
        
        if($tipo == 'chamada'){
            $rules = array(
                'aluno_id' => 'required',
                'turma_id' => 'required',
                'data' => 'required',
                'hora' => 'required',
                'justif' => 'required'
            );
        }else{
            $rules = array(
                'func_id' => 'required',
                'data' => 'required',
                'hora_entrada' => 'required',
                'hora_saida' => 'required',
                'justif' => 'required'
            );
        }
        
        $validator = Validator($request->all(), $rules);
        
        if ($validator->fails()) {
            return redirect($this->area . '/manual')
                            ->withErrors($validator)
                            ->withInput($request->all());
        } else {
            if($tipo == 'chamada'){
                $getChamada = Ponto::where([
                    'data' => $request->get('data'),
                    'usuario_id' => $request->get('func_id'),
                    'turma_id' => $request->get('turma_id')
                    ])->get();
                
                if(count($getChamada) > 0 ){
                    foreach($getChamada as $destChamada){
                        Chamada::destroy($destChamada->id);
                    }
                }                
                
                $chamada = new Chamada;
                $chamada->usuario_id = $request->get('aluno_id');
                $chamada->turma_id = $request->get('turma_id');
                $chamada->data = $request->get('data');
                $chamada->hora = $request->get('hora');
                $chamada->justificativa = $request->get('justif');
                $chamada->save();
            }else{
                $getPonto = Ponto::where([
                    'data' => $request->get('data'),
                    'usuario_id' => $request->get('func_id')
                    ])->get();
                
                if(count($getPonto) > 0 ){
                    foreach($getPonto as $ponto){
                        Ponto::destroy($ponto->id);
                    }
                }
                
                if($request->get('hora_entrada') !== ''){
                    $pontoEntrada = new Ponto;
                    $pontoEntrada->usuario_id = $request->get('func_id');
                    $pontoEntrada->data = $request->get('data');
                    $pontoEntrada->hora = $request->get('hora_entrada');
                    $pontoEntrada->tipo = 'entrada';
                    $pontoEntrada->justificativa = $request->get('justif');
                    $pontoEntrada->save();
                }
                
                if($request->get('hora_saida') !== ''){
                    $pontoSaida = new Ponto;
                    $pontoSaida->usuario_id = $request->get('func_id');
                    $pontoSaida->data = $request->get('data');
                    $pontoSaida->hora = $request->get('hora_saida');
                    $pontoSaida->tipo = 'saida';
                    $pontoSaida->justificativa = $request->get('justif');
                    $pontoSaida->save();
                }
            }

            // redirect
            Session::flash('success', 'Registro inserido com sucesso!');
            return redirect($this->area . '/manual');
        }
   }
}