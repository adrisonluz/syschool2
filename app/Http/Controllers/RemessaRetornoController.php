<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Usuario;
use App\Boleto;
use App\RemessaRetorno;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\App;
use Auth;

class RemessaRetornoController extends Controller {

    public $area;

    public function __construct() {
        $this->middleware('auth');
        $this->area = 'remessa-retorno';
        $this->arrayReturn = array('usuarioLogado' => $this->usuarioLogado = Auth::user());

        $this->mapList = array(
            array('nome' => 'Remessas / Retornos', 'icon' => 'fa-file-text-o', 'link' => '/' . $this->area)
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $pageTitle = 'Remessas / Retornos';

        $remessas = RemessaRetorno::where('tipo', 'remessa')->orderBy('id', 'DESC')->get();
        $retornos = RemessaRetorno::where('tipo', 'retorno')->orderBy('id', 'DESC')->get();

        if (Session::has('alert')) {
            $session = Session::get('alert');
        } else {
            $session = '';
        }

        $this->arrayReturn += [
            'remessas' => $remessas,
            'retornos' => $retornos,
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
    public function create($remessaRetorno) {
        $pageTitle = ($remessaRetorno == 'remessa' ? 'Nova remessa' : 'Novo retorno');
        $this->mapList[] = array('nome' => 'Novo', 'icon' => 'fa-plus', 'link' => '/' . $this->area . '/create/' . $remessaRetorno);

        if ($remessaRetorno == 'remessa') {
            $boletos = Boleto::where(['remessa_retorno_id' => null, 'lixeira' => null])->orderBy('id', 'desc')->get();
        } else {
            $boletos = null;
        }

        $this->arrayReturn += [
            'remessaRetorno' => $remessaRetorno,
            'boletos' => $boletos,
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
    public function store($remessaRetorno) {

        if ($remessaRetorno == 'remessa') {
            $remessa = new RemessaRetorno;
            $remessa->data_geracao = new \DateTime();
            $remessa->data_gravacao = new \DateTime();
            $remessa->tipo = 'remessa';
            $remessa->caminho = 'remessas/remessa_' . date('dmY') . '.txt';
            $remessa->status = 'não enviado';

            if ($remessa->save()) {
                $id_boleto = $_POST['boletos'];
                $id_remessa = $remessa->id;
                $remessa->remessa($id_boleto, $id_remessa);

                Session::flash('remessa', $remessa->id);
            }
        }

        // redirect
        Session::flash('success', 'Boleto emitido com sucesso!');
        return redirect($this->area);
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

    public function verBoletos($remessa_retorno_id = '') {
        $remessa_retorno_id = (!empty($_POST['remessa_retorno_id']) ? $_POST['remessa_retorno_id'] : $remessa_retorno_id);
        $remessaRetorno = RemessaRetorno::find($remessa_retorno_id);

        foreach ($remessaRetorno->boletos as $boleto) {
            if ($boleto->usuario == null) {
                $boleto->usuario = objectValue();
                $boleto->usuario->nome = 'não declarado';
            }

            $result[$boleto->id] = array(
                'nome' => $boleto->usuario->nome,
                'valor' => $boleto->valor,
                'status' => $boleto->status
            );
        }

        return json_encode($result);
    }

}
