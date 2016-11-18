<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Usuario;
use App\Boleto;
use App\Matricula;
use App\Turma;
use App\RemessaRetorno;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use DOMPDF;
use Illuminate\Support\Facades\App;
use App\BoletoDoc;
use Illuminate\Support\Facades\Auth;

class BoletosController extends Controller {

    public $area;

    public function __construct() {
        $this->middleware('auth');
        $this->area = 'boletos';
        $this->arrayReturn = array('usuarioLogado' => $this->usuarioLogado = Auth::user());

        $this->mapList = array(
            array('nome' => 'Boletos', 'icon' => 'fa-file-text-o', 'link' => '/' . $this->area)
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $pageTitle = 'Boletos';

        $boletos = Boleto::all();
        $alunos = Usuario::where(['nivel' => 'aluno', 'lixeira' => null])->get();

        if (Session::has('alert')) {
            $session = Session::get('alert');
        } else {
            $session = '';
        }

        $this->arrayReturn += [
            'alunos' => $alunos,
            'boletos' => $boletos,
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
        $pageTitle = 'Boletos - Emitir';
        $this->mapList[] = array('nome' => 'Emitir', 'icon' => 'fa-plus', 'link' => '/' . $this->area . '/create');

        $ultimoBoleto = Boleto::where('lixeira', null)->orderBy('id', 'desc')->get()->first();
        $alunos = Usuario::where(['nivel' => 'aluno', 'lixeira' => null])->get();

        $this->arrayReturn += [
            'alunos' => $alunos,
            'ultimoBoleto' => $ultimoBoleto,
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
            'valor' => 'required',
            'data_vencimento' => 'required',
            'data_emissao' => 'required',
            'referencia' => 'required',
            'competencia' => 'required',
            'sequencial' => 'required',
        );

        $validator = Validator($request->all(), $rules);

        if ($validator->fails()) {
            return redirect($this->area . '/create')
                            ->withErrors($validator)
                            ->withInput($request->all());
        } else {
            // store
            $boleto = new Boleto;
            $boleto->usuario_id = $request->get('usuario_id');
            $boleto->data_vencimento = $request->get('data_vencimento');
            $boleto->data_emissao = $request->get('data_emissao');

            $boleto->referencia = ($request->get('referencia') == 'change' ? 'mensalidade' : $request->get('referencia'));

            $boleto->competencia = $request->get('competencia');
            $seq = $request->get('sequencial') . $request->get('usuario_id');
            $boleto->sequencial = $seq;
            $boleto->linha = $seq;
            $boleto->status = 'aberto';

            $verificaBoleto = Boleto::where([
                        'usuario_id' => $boleto->usuario_id,
                        'competencia' => $boleto->competencia
                    ])->get()->toArray();

            if (count($verificaBoleto) > 0) {
                Session::flash('error', 'Já existe um boleto nesta competência. Deseja editá-lo?');
                Session::flash('boleto_id', $verificaBoleto[0]['id']);
                return redirect($this->area . '/create');
            }

            $valor = str_replace(',', '.', $request->get('valor'));

            if ($boleto->referencia == 'mensalidade') {
                $usuario = Usuario::find($boleto->usuario_id);
                $matriculas = Matricula::where('usuario_id', $boleto->usuario_id)->get()->toArray();

                foreach ($matriculas as $matricula) {
                    $mensalidades[] = Turma::select('mensalidade')->find($matricula['turma_id'])->toArray();
                }

                foreach ($mensalidades as $mensalidade => $valorMensal) {
                    $valores[] = $valorMensal['mensalidade'];
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
            } else {
                $boleto->valor = $valor;
            }

            $boleto->save();

            // redirect
            Session::flash('success', 'Boleto emitido com sucesso!');
            Session::flash('boleto_id', $boleto->id);
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
        $boleto = Boleto::find($id);

        if ($boleto->usuario_id !== '') {
            $usuario = Usuario::find($boleto->usuario_id);
        } else {
            $usuario = '';
        }

        $alunos = Matricula::where(['turma_id' => $id])->get();

        $pageTitle = 'Boleto - ' . $boleto->sequencial . ' | ' . $boleto->status;

        $this->arrayReturn += [
            'boleto' => $boleto,
            'usuario' => $usuario,
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
        $boleto = Boleto::find($id);

        $alunos = Usuario::where(['nivel' => 'aluno', 'lixeira' => null])->get();

        $pageTitle = 'Boletos - Editar: ' . $boleto->sequencial . ' | ' . $boleto->status;
        $this->mapList[] = array('nome' => 'Editar', 'icon' => 'fa-edit', 'link' => '/' . $this->area . '/' . $id . '/edit');

        if ($boleto) {
            $this->arrayReturn += [
                'boleto' => $boleto,
                'alunos' => $alunos,
                'page_title' => $pageTitle,
                'mapList' => $this->mapList
            ];

            return view($this->area . '/editar', $this->arrayReturn);
        } else {
            Session::flash('error', 'Boleto não encontrado!');
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
            'valor' => 'required',
            'data_vencimento' => 'required',
            //'data_emissao' => 'required',
            'referencia' => 'required',
            'competencia' => 'required',
            'sequencial' => 'required',
        );

        $validator = Validator($request->all(), $rules);

        if ($validator->fails()) {
            return redirect($this->area . '/' . $id . '/edit')
                            ->withErrors($validator)
                            ->withInput($request->all());
        } else {
            // store
            $boleto = Boleto::find($id);
            $boleto->usuario_id = $request->get('usuario_id');
            $boleto->data_vencimento = $request->get('data_vencimento');
            $boleto->data_emissao = $request->get('data_emissao');

            $boleto->referencia = ($request->get('referencia') == 'change' ? 'mensalidade' : $request->get('referencia'));

            $boleto->competencia = $request->get('competencia');
            $boleto->sequencial = $request->get('sequencial');
            $boleto->linha = $request->get('sequencial');
            $boleto->status = $request->get('status');

            $valor = str_replace(',', '.', $request->get('valor'));

            if ($boleto->referencia == 'mensalidade') {
                $usuario = Usuario::find($boleto->usuario_id);
                $matriculas = Matricula::where('usuario_id', $boleto->usuario_id)->get()->toArray();

                foreach ($matriculas as $matricula) {
                    $mensalidades[] = Turma::select('mensalidade')->find($matricula['turma_id'])->toArray();
                }

                foreach ($mensalidades as $mensalidade => $valorMensal) {
                    $valores[] = $valorMensal['mensalidade'];
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
            } else {
                $boleto->valor = $valor;
            }

            $boleto->save();


            // redirect
            Session::flash('success', 'Boleto editado com sucesso!');
            Session::flash('boleto_id', $boleto->id);
            return redirect($this->area);
        }
    }

    public function excluir(Request $request, $id) {
        $boleto = Boleto::find($id);

        // redirect
        Session::flash('excluir', 'Tem certeza que deseja excluir o boleto ' . $boleto->sequencial . '?');
        Session::flash('boleto_id', $boleto->id);
        return redirect($this->area);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        Boleto::destroy($id);

        Session::flash('success', 'Boleto excluído com sucesso.');
        return redirect($this->area);
    }

    public function getMensalidade($id = '') {
        $usuario_id = (!empty($_POST['usuario_id']) ? $_POST['usuario_id'] : $usuario_id);

        $boleto = new Boleto;
        $mensalidade = $boleto->calculaMensalidade($usuario_id);

        return json_encode($mensalidade);
    }

    public function printBoleto($boleto_id) {
        $doc = new BoletoDoc;
        $boleto = Boleto::find($boleto_id);

        $desc = '';
        $matriculas = Matricula::where('usuario_id', $boleto->usuario_id)->get()->toArray();

        foreach ($matriculas as $matricula) {
            $turma = Turma::find($matricula['turma_id']);
            $descTurmas[] = 'Turma: ' . $turma->curso->nome . ' | ' . $turma->professor->nome;
        }

        if ($boleto->usuario) {
            switch ($boleto->usuario->desconto) {
                case 'familia':
                case 'fidelidade':
                    $descDesconto = ' 40% sobre o menor valor de mensalidade matriculada.';
                    break;
                case 'isento':
                    $descDesconto = ' 100% sobre todas as mensalidades.';
                    break;
                case 'auxilio':
                    $descDesconto = ' Bolsa no valor de R$ 75,00.';
                    $boleto->valor = '75.00';
                    break;
                default:
                    $descDesconto = ' nenhum';
                    //$boleto->valor = $valor;
                    break;
            }
        } else {
            $descDesconto = '';
        }

        $descTurmas[] = 'Desconto: ' . $descDesconto;

        $doc->SetUsuarioID($boleto->usuario_id);
        $doc->SetDataEmissao($boleto->data_emissao);
        $doc->SetDataVencimento($boleto->data_vencimento);
        $doc->SetValor($boleto->valor);
        $doc->SetSeq($boleto->sequencial);
        $doc->SetDescDemo($descTurmas);
        $doc->SetDesconto($boleto->desconto);

        $pdf = new Dompdf();
        $pdf->set_paper('A4', 'landscape');
        $pdf->load_html($doc->emitirBoleto());
        //$pdf->render();
        //$pdf = App::make('dompdf.wrapper',array());

        $pdf->stream('boleto.pdf');
    }

}
