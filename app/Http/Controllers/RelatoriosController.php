<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Usuario;
use App\Turma;
use App\Matricula;
use App\Chamada;
use App\Ponto;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Hash;
use Auth;
use DOMPDF;

class RelatoriosController extends Controller {

    public $area;

    public function __construct() {
        $this->middleware('auth');
        $this->area = 'relatorios';
        $this->arrayReturn = array('usuarioLogado' => $this->usuarioLogado = Auth::user());

        $this->mapList = array(
            array('nome' => 'Relatórios', 'icon' => 'fa-user', 'link' => '/' . $this->area)
        );
    }

    public function usuarios() {
        $pageTitle = 'Relatório - Usuários';
        $this->mapList[] = array('nome' => 'Usuários', 'icon' => 'fa-user', 'link' => '/' . $this->area . '/usuarios');

        if (Session::has('alert')) {
            $session = Session::get('alert');
        } else {
            $session = '';
        }
        
        $result = Usuario::all();

        $this->arrayReturn += [
            'page_title' => $pageTitle,
            'mapList' => $this->mapList,
            'session' => $session,
            'result' => $result
        ];

        return view($this->area . '.usuarios', $this->arrayReturn);
    }
    
    public function usuariosResult() {
        $pageTitle = 'Relatório - Usuários | Resultado';
        $this->mapList[] = array('nome' => 'Usuários | Resultado', 'icon' => 'fa-user', 'link' => '/' . $this->area . '/usuarios');

        if (Session::has('alert')) {
            $session = Session::get('alert');
        } else {
            $session = '';
        }

        $campos = array();   
        $tipoBusca = $_POST['busca_por'];
        $dataIni = ($_POST['periodo_de'] !== '' && $_POST['periodo_de'] !== '00/00/0000' ? $_POST['periodo_de'] : '31/12/1969');
        $dataFim = ($_POST['periodo_ate'] !== '' && $_POST['periodo_ate'] !== '00/00/0000' ? $_POST['periodo_ate'] : date('d/m/Y'));
        $busca_nivel = (!empty($_POST['busca_nivel']) ? $_POST['busca_nivel'] : '');
        
        foreach($_POST as $postKey => $postVal){
            if($postVal == 'on'){
                $camposArray[] = $postKey;
                unset($_POST[$postKey]);
            }
        }
        $camposArray[] = 'id';
        $result = array();
        
        switch($tipoBusca){
            case 'data_cadastro':
                $getResult = Usuario::select($camposArray)
                    ->where('criacao', '>=', implode('-', array_reverse(explode('/', $dataIni))))
                    ->where('criacao', '<=', implode('-', array_reverse(explode('/', $dataFim))));
                
                if($busca_nivel !== ''){
                    $getResult->where('nivel', $busca_nivel);
                }
                
                $result = $getResult->get()
                    ->toArray();
                break;
            case 'turmas_relac':
                $getResult = Usuario::select($camposArray);
                
                if($busca_nivel !== ''){
                    $getResult->where('nivel', $busca_nivel);
                }
                
                $result = $getResult->get()
                        ->toArray();              
                $iT = 0;
                foreach($getResult->get() as $getTurma){
                    $result[$iT]['relTurmas'] = array();
                    if(count($getTurma->matricula) > 0){
                        foreach($getTurma->matricula as $turmas){
                            $result[$iT]['relTurmas'][] = array(
                                'nivel' => 'Aluno',
                                'modulo' => $turmas->modulo->nome,
                                'curso' => $turmas->curso->nome,
                                'professor' => $turmas->professor->nome  
                            );
                        }
                    }
                    
                    if(count($getTurma->turmas) > 0){
                        foreach($getTurma->turmas as $turmas){
                            $result[$iT]['relTurmas'][] = array(
                                'nivel' => 'Professor',
                                'modulo' => $turmas->modulo->nome,
                                'curso' => $turmas->curso->nome,
                                'professor' => $turmas->professor->nome  
                            );
                        }
                    }
                    
                    $iT++;
                }                
                break;
        }
      
        foreach($camposArray as $camposVal){
            switch($camposVal){
                case 'nome':
                $camposVal = 'Nome';
                break;
              case 'nascimento':
                $camposVal = 'Nascimento';
                break;
              case 'rg':
                $camposVal = 'RG';
                break;
              case 'cpf':
                $camposVal = 'CPF';
                break;
              case 'matricula':
                $camposVal = 'Matricula';
                break;
              case 'nivel':
                $camposVal = 'Nivel';
                break;
              case 'emerg_nome':
                $camposVal = 'Emergência Nome';
                break;
              case 'emerg_telefone':
                $camposVal = 'Emergência Telefone';
                break;
              case 'problema_saude':
                $camposVal = 'Problemas de Saúde';
                break;
              case 'alergia':
                $camposVal = 'Alergia';
                break;
              case 'medicamento':
                $camposVal = 'Medicamento';
                break;
              case 'nome_boleto':
                $camposVal = 'Boleto Nome';
                break;
              case 'cpf_boleto':
                $camposVal = 'Boleto CPF';
                break;
              case 'desconto':
                $camposVal = 'Desconto';
                break;
              case 'nome_banco':
                $camposVal = 'Banco Nome';
                break;
              case 'agencia_banco':
                $camposVal = 'Banco Agência';
                break;
              case 'conta_banco':
                $camposVal = 'Banco Conta';
                break;
              case 'telefone':
                $camposVal = 'Telefone';
                break;
              case 'celular':
                $camposVal = 'Celular';
                break;
              case 'email':
                $camposVal = 'Email';
                break;
              case 'nome_pai':
                $camposVal = 'Pai Nome';
                break;
              case 'cel_pai':
                $camposVal = 'Pai Celular';
                break;
              case 'nome_mae':
                $camposVal = 'Mãe Nome';
                break;
              case 'cel_mae':
                $camposVal = 'Mãe Celular';
                break;
              case 'nome_outro':
                $camposVal = 'Outro Nome';
                break;
              case 'cel_outro':
                $camposVal = 'Outro Celular';
                break;
              case 'vinculo':
                $camposVal = 'Outro Vinculo';
                break;
              case 'email_resp':
                $camposVal = 'Email Responsável';
                break;
              case 'endereco':
                $camposVal = 'Endereço';
                break;
              case 'bairro':
                $camposVal = 'Bairro';
                break;
              case 'cidade':
                $camposVal = 'Cidade';
                break;
              case 'cep':
                $camposVal = 'CEP';
                break;
            }
            $campos[] = $camposVal;
        }
        unset($camposArray);
        
        $this->arrayReturn += [
            'page_title' => $pageTitle,
            'mapList' => $this->mapList,
            'session' => $session,
            'campos' => $campos,
            'result' => $result,
            'tipoBusca' => $tipoBusca
        ];

        return view($this->area . '.usuarios_result', $this->arrayReturn);
    }
    
    public function chamadas(){
        $pageTitle = 'Relatório - Chamadas';
        $this->mapList[] = array('nome' => 'Chamadas', 'icon' => 'fa-user', 'link' => '/' . $this->area . '/chamadas');
        
        $alunos = Usuario::select(['id','nome'])
            ->whereIn('nivel', ['aluno','aluno_prof'])
            ->where('lixeira', null)
            ->get();
        $turmas = Turma::all();

        if (Session::has('alert')) {
            $session = Session::get('alert');
        } else {
            $session = '';
        }

        $this->arrayReturn += [
            'page_title' => $pageTitle,
            'mapList' => $this->mapList,
            'session' => $session,
            'alunos' => $alunos,
            'turmas' => $turmas
        ];

        return view($this->area . '.chamadas', $this->arrayReturn);
    }
    
    public function chamadasResult(){
        $pageTitle = 'Relatório - Chamadas | Resultado';
        $this->mapList[] = array('nome' => 'Chamadas | Resultado', 'icon' => 'fa-user', 'link' => '/' . $this->area . '/chamadas');
        
        if (Session::has('alert')) {
            $session = Session::get('alert');
        } else {
            $session = '';
        }

        
        $campos = array();   
        $buscaAluno = $_POST['busca_aluno'];
        $buscaTurma = $_POST['busca_turma'];
        
        $dataIni = ($_POST['periodo_de'] !== '' && $_POST['periodo_de'] !== '00/00/0000' ? $_POST['periodo_de'] : '31/12/1969');
        $dataFim = ($_POST['periodo_ate'] !== '' && $_POST['periodo_ate'] !== '00/00/0000' ? $_POST['periodo_ate'] : date('d/m/Y'));
        
        foreach($_POST as $postKey => $postVal){
            if($postVal == 'on'){
                $camposArray[] = $postKey;
                unset($_POST[$postKey]);
            }
        }
        $camposArray[] = 'id';
        
        $getResult = Chamada::select($camposArray)
                                ->where('criacao', '>=', implode('-', array_reverse(explode('/', $dataIni))))
                                ->where('criacao', '<=', implode('-', array_reverse(explode('/', $dataFim))));
        
        if($buscaAluno !== '')
            $getResult->where('usuario_id', $buscaAluno);
        
        if($buscaTurma !== '')
            $getResult->where('turma_id', $buscaTurma);
        
        $iR = 0;
        $result = array();
        foreach($getResult->get()->toArray() as $resultado){
            foreach($resultado as $resultKey => $resultVal){
                if($resultKey == 'usuario_id'){
                    $aluno = Usuario::find($resultVal);
                    $result[$iR][$resultKey] = $aluno->nome;     
                }elseif($resultKey == 'turma_id'){
                    $turma = Turma::find($resultVal);
                    $result[$iR][$resultKey] = $turma->modulo->nome . ' - ' . $turma->curso->nome . ' - ' . $turma->professor->nome;
                }else{
                    $result[$iR][$resultKey] = $resultVal;
                }
            }
            $iR++;
        }
      
        foreach($camposArray as $camposVal){
            switch($camposVal){
                case 'usuario_id':
                    $camposVal = 'Aluno';
                    break;
                case 'turma_id':
                    $camposVal = 'Turma';
                    break;
                case 'data':
                    $camposVal = 'Data';
                    break;
                case 'hora':
                    $camposVal = 'Hora';
                    break;
            }
            $campos[] = $camposVal;
        }
        unset($camposArray);
        
        $this->arrayReturn += [
            'page_title' => $pageTitle,
            'mapList' => $this->mapList,
            'session' => $session,
            'campos' => $campos,
            'result' => $result
        ];

        return view($this->area . '.chamadas_result', $this->arrayReturn);
    }
    
    public function ponto(){
        $pageTitle = 'Relatório - Ponto';
        $this->mapList[] = array('nome' => 'Ponto', 'icon' => 'fa-user', 'link' => '/' . $this->area . '/pontos');
        
        $funcionarios = Usuario::select(['id','nome'])
            ->whereIn('nivel', ['aluno_prof','prof_func','sec'])
            ->where('lixeira', null)
            ->get();

        if (Session::has('alert')) {
            $session = Session::get('alert');
        } else {
            $session = '';
        }
        
        $this->arrayReturn += [
            'page_title' => $pageTitle,
            'mapList' => $this->mapList,
            'session' => $session,
            'funcionarios' => $funcionarios
        ];

        return view($this->area . '.ponto', $this->arrayReturn);        
    }
    
    public function pontoResult(){
        $pageTitle = 'Relatório - Ponto | Resultado';
        $this->mapList[] = array('nome' => 'Ponto | Resultado', 'icon' => 'fa-user', 'link' => '/' . $this->area . '/ponto');
        
        if (Session::has('alert')) {
            $session = Session::get('alert');
        } else {
            $session = '';
        }
        
        $campos = array();   
        $buscaFunc = (!empty($_POST['busca_func']) ? $_POST['busca_func'] : '');
        $buscaTipo = (!empty($_POST['busca_tipo']) ? $_POST['busca_tipo'] : '');
        $buscaAcao = (!empty($_POST['busca_acao']) ? $_POST['busca_acao'] : '');
        
        $dataIni = ($_POST['periodo_de'] !== '' && $_POST['periodo_de'] !== '00/00/0000' ? $_POST['periodo_de'] : '31/12/1969');
        $dataFim = ($_POST['periodo_ate'] !== '' && $_POST['periodo_ate'] !== '00/00/0000' ? $_POST['periodo_ate'] : date('d/m/Y'));
        
        foreach($_POST as $postKey => $postVal){
            if($postVal == 'on'){
                $camposArray[] = $postKey;
                unset($_POST[$postKey]);
            }
        }
        $camposArray[] = 'id';
        
        $getResult = Ponto::select($camposArray)
                                ->where('criacao', '>=', implode('-', array_reverse(explode('/', $dataIni))))
                                ->where('criacao', '<=', implode('-', array_reverse(explode('/', $dataFim))));
        
        if($buscaFunc !== '')
            $getResult->where('usuario_id', $buscaFunc);
        
        if($buscaTipo !== '')
            $getResult->where('tipo', $buscaTipo);
        
        $iR = 0;
        $iSoma = 0; 
        $result = array();
        foreach($getResult->get()->toArray() as $resultado){
            foreach($resultado as $resultKey => $resultVal){
                if($resultKey == 'usuario_id'){
                    $funcionario = Usuario::find($resultVal);
                    $result[$iR][$resultKey] = $funcionario->nome;     
                }else{
                    $result[$iR][$resultKey] = $resultVal;
                }
            }
            $iR++;
        }
        
        $resultHoras = array();
        if($buscaAcao == 'calc_horas'){
            $getFuncHoras = Ponto::select(['id','usuario_id','data','hora','tipo']);
            
            if($buscaFunc !== '')
            $getFuncHoras->where('usuario_id', $buscaFunc);
            
            $getFuncHoras->where('criacao', '>=', implode('-', array_reverse(explode('/', $dataIni))))
                    ->where('criacao', '<=', implode('-', array_reverse(explode('/', $dataFim))));
            
            foreach($getFuncHoras->get() as $getFunc){
                if(!isset($resultHoras[$getFunc->usuario_id]['total'])){
                    $resultHoras[$getFunc->usuario_id]['total'] = 0;
                    $resultHoras[$getFunc->usuario_id]['diasTotal'] = 0;
                }
                
                $dateExp = explode('/',$getFunc->data);
                $getFunc->data = $dateExp[2] . '-' . $dateExp[1] . '-' . $dateExp[0];
                
                if($getFunc->tipo == 'entrada'){
                    $resultHoras[$getFunc->usuario_id]['nome'] = Usuario::find($getFunc->usuario_id)->nome;
                    $resultHoras[$getFunc->usuario_id]['data'] = $getFunc->data;
                    $resultHoras[$getFunc->usuario_id]['entrada'] = strtotime($getFunc->data . ' ' . $getFunc->hora);
                }elseif($getFunc->tipo == 'saida' 
                        && $resultHoras[$getFunc->usuario_id]['data'] == $getFunc->data
                        && $resultHoras[$getFunc->usuario_id]['entrada'] !== ''){
                    
                    $resultHoras[$getFunc->usuario_id]['total'] +=  (
                                    strtotime($getFunc->data . ' ' . $getFunc->hora) - $resultHoras[$getFunc->usuario_id]['entrada']
                                    );
                    $resultHoras[$getFunc->usuario_id]['entrada'] = '';
                    $resultHoras[$getFunc->usuario_id]['diasTotal']++;
                }                
            }
            $resultHoras[$getFunc->usuario_id]['total'] = gmdate("H:i",$resultHoras[$getFunc->usuario_id]['total']);
        }
        
        foreach($camposArray as $camposVal){
            switch($camposVal){
                case 'usuario_id':
                    $camposVal = 'Funcionário';
                    break;
                case 'tipo':
                    $camposVal = 'Tipo';
                    break;
                case 'data':
                    $camposVal = 'Data';
                    break;
                case 'hora':
                    $camposVal = 'Hora';
                    break;
            }
            $campos[] = $camposVal;
        }
        unset($camposArray);
        
        $this->arrayReturn += [
            'page_title' => $pageTitle,
            'mapList' => $this->mapList,
            'session' => $session,
            'campos' => $campos,
            'result' => $result,
            'buscaAcao' => $buscaAcao,
            'resultHoras' => $resultHoras
        ];

        return view($this->area . '.ponto_result', $this->arrayReturn);
    }

    public function imprimir() {
        $dados = $_POST['htmlTable'];
        $tipo = $_POST['tipo'];
        
        $pdf = new Dompdf();
        $pdf->set_paper('A4', 'landscape');
        //return view($this->area.'.imprimir', array( 'dados' => $dados, 'tipo' => $tipo));
        $pdf->load_html(view($this->area.'.imprimir', array( 'dados' => $dados, 'tipo' => $tipo)));
        $pdf->render();

        $pdf->stream('relatorio_' . $tipo . '_' . date('dmY_h') . '.pdf');
    }
}
