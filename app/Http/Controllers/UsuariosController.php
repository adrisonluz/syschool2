<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Usuario;
use App\Turma;
use App\Matricula;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use App\Code;
use Illuminate\Support\Facades\Hash;
use Auth;
use DOMPDF;

class UsuariosController extends Controller {

    public $area;

    public function __construct() {
        $this->middleware('auth');
        $this->area = 'usuarios';
        $this->arrayReturn = array('usuarioLogado' => $this->usuarioLogado = Auth::user());
        //$this->arrayReturn = array('usuarioLogado' => New Usuario);

        $this->mapList = array(
            array('nome' => 'Usuários', 'icon' => 'fa-user', 'link' => '/' . $this->area)
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $pageTitle = 'Usuários';

        $alunos = Usuario::where(['nivel' => 'aluno', 'lixeira' => null])->get();
        $professores = Usuario::whereNotIn('nivel', array('aluno'))->where('lixeira', null)->get();

        if (Session::has('alert')) {
            $session = Session::get('alert');
        } else {
            $session = '';
        }

        $this->arrayReturn += [
            'alunos' => $alunos,
            'professores' => $professores,
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
        $pageTitle = 'Usuários - Cadastro';
        $turmas = Turma::all();

        $this->mapList[] = array('nome' => 'Cadastro', 'icon' => 'fa-plus', 'link' => '/' . $this->area . '/create');

        $this->arrayReturn += [
            'turmas' => $turmas,
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
            'nascimento' => 'required',
            'endereco' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'nome_boleto' => 'required',
            'cpf_boleto' => 'required'
        );

        $validator = Validator($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect($this->area . '/create')
                            ->withErrors($validator)
                            ->withInput($request->all());
        } else {
            // store    
            $usuario = new Usuario;
            $usuario->idade = getIdade($request->get('nascimento'));
            $usuario->nome = $request->get('nome');
            $usuario->rg = $request->get('rg');
            $usuario->cpf = $request->get('cpf');
            $usuario->nascimento = data($request->get('nascimento'), false);

            $niver = explode('/', $request->get('nascimento'));
            $niver = $niver[0] . '-' . $niver[1];
            $usuario->niver = $niver;

            $usuario->email = $request->get('email');
            $usuario->telefone = $request->get('telefone');
            $usuario->celular = $request->get('celular');
            $usuario->login = $request->get('login');
            $usuario->password = Hash::make($request->get('password'));
            $usuario->endereco = $request->get('endereco');
            $usuario->bairro = $request->get('bairro');
            $usuario->cidade = $request->get('cidade');
            $usuario->cep = $request->get('cep');
            $usuario->nome_pai = $request->get('nome_pai');
            $usuario->cel_pai = $request->get('cel_pai');
            $usuario->nome_mae = $request->get('nome_mae');
            $usuario->cel_mae = $request->get('cel_mae');
            $usuario->nome_outro = $request->get('nome_outro');
            $usuario->cel_outro = $request->get('cel_outro');
            $usuario->email_resp = $request->get('email_resp');
            $usuario->vinculo = $request->get('vinculo');
            $usuario->nome_boleto = $request->get('nome_boleto');
            $usuario->cpf_boleto = $request->get('cpf_boleto');
            $usuario->desconto = $request->get('desconto');
            $usuario->nome_banco = $request->get('nome_banco');
            $usuario->agencia_banco = $request->get('agencia_banco');
            $usuario->conta_banco = $request->get('conta_banco');
            $usuario->emerg_nome = $request->get('emerg_nome');
            $usuario->emerg_telefone = $request->get('emerg_telefone');
            $usuario->problema_saude = $request->get('problema_saude');
            $usuario->alergia = $request->get('alergia');
            $usuario->medicamento = $request->get('medicamento');
            $usuario->observacoes = $request->get('observacoes');
            $usuario->nivel = $request->get('nivel');

            if ($request->get('codeImagem')) {
                $usuario->foto = $usuario->id . '_' . date('dmYhi') . '.png';
                $usuario->setImagemFoto($request->get('codImagem'), $usuario->foto);
            }

            $usuario->save();

            $qrCode = new Code;
            $qrCode->setQRUsuario($usuario->id);

            if ($request->get('turmas') !== null) {
                foreach ($request->get('turmas') as $turma) {
                    $matricula = new Matricula;
                    $matricula->turma_id = $turma;
                    $matricula->usuario_id = $usuario->id;
                    $matricula->save();
                }
            }

            // redirect
            Session::flash('success', 'Usuário cadastrado com sucesso!');
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
        $usuario = Usuario::find($id);

        $pageTitle = 'Usuários - Perfil: ' . $usuario->nome;
        $this->mapList[] = array(
            'nome' => 'Perfil',
            'icon' => 'fa-user',
            'link' => '/' . $this->area . '/' . $id
        );

        $this->arrayReturn += [
            'usuario' => $usuario,
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
        $usuario = Usuario::find($id);
        $turmas = Turma::all();

        $matriculado = array();
        $matriculas = Matricula::select('turma_id')->where('usuario_id', $id)->get()->toArray();
        if (count($matriculas) > 0) {
            foreach ($matriculas as $matricula) {
                $matriculado[] = $matricula['turma_id'];
            }
        }


        $pageTitle = 'Usuários - Editar: ' . $usuario->nome;
        $this->mapList[] = array('nome' => 'Editar', 'icon' => 'fa-edit', 'link' => '/' . $this->area . '/' . $id . '/edit');

        if ($usuario) {
            $this->arrayReturn += [
                'usuario' => $usuario,
                'turmas' => $turmas,
                'matriculas' => $matriculado,
                'page_title' => $pageTitle,
                'mapList' => $this->mapList
            ];

            return view($this->area . '/editar', $this->arrayReturn);
        } else {
            Session::flash('error', 'Usuário não encontrado!');
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
            'nome' => 'required',
            'nascimento' => 'required',
            'endereco' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'nome_boleto' => 'required',
            'cpf_boleto' => 'required'
        );

        $validator = Validator($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect($this->area . '/' . $id . '/edit')
                            ->withErrors($validator)
                            ->withInput($request->all());
        } else {
            // store
            $usuario = Usuario::find($id);
            $usuario->idade = getIdade($request->get('nascimento'));
            $usuario->nome = $request->get('nome');
            $usuario->rg = $request->get('rg');
            $usuario->cpf = $request->get('cpf');
            $usuario->nascimento = data($request->get('nascimento'), false);

            $niver = explode('/', $request->get('nascimento'));
            $niver = $niver[0] . '-' . $niver[1];
            $usuario->niver = $niver;

            $usuario->email = $request->get('email');
            $usuario->telefone = $request->get('telefone');
            $usuario->celular = $request->get('celular');
            $usuario->login = $request->get('login');

            if ($request->get('password') !== '') {
                $usuario->password = Hash::make($request->get('password'));
            }

            $usuario->endereco = $request->get('endereco');
            $usuario->bairro = $request->get('bairro');
            $usuario->cidade = $request->get('cidade');
            $usuario->cep = $request->get('cep');
            $usuario->nome_pai = $request->get('nome_pai');
            $usuario->cel_pai = $request->get('cel_pai');
            $usuario->nome_mae = $request->get('nome_mae');
            $usuario->cel_mae = $request->get('cel_mae');
            $usuario->nome_outro = $request->get('nome_outro');
            $usuario->cel_outro = $request->get('cel_outro');
            $usuario->email_resp = $request->get('email_resp');
            $usuario->vinculo = $request->get('vinculo');
            $usuario->nome_boleto = $request->get('nome_boleto');
            $usuario->cpf_boleto = $request->get('cpf_boleto');
            $usuario->desconto = $request->get('desconto');
            $usuario->nome_banco = $request->get('nome_banco');
            $usuario->agencia_banco = $request->get('agencia_banco');
            $usuario->conta_banco = $request->get('conta_banco');
            $usuario->emerg_nome = $request->get('emerg_nome');
            $usuario->emerg_telefone = $request->get('emerg_telefone');
            $usuario->problema_saude = $request->get('problema_saude');
            $usuario->alergia = $request->get('alergia');
            $usuario->medicamento = $request->get('medicamento');
            $usuario->observacoes = $request->get('observacoes');
            $usuario->nivel = $request->get('nivel');

            if ($request->get('codImagem')) {
                $usuario->foto = $usuario->id . '_' . date('dmYhi') . '.png';

                if (Storage::disk('perfil')->exists($usuario->foto . '.png')) {
                    Storage::disk('perfil')->delete($usuario->foto . '.png');
                }

                $usuario->foto = 'perfil_' . $usuario->id . '.png';
                $usuario->setImagemFoto($request->get('codImagem'), $usuario->foto);
            }

            if ($request->get('turmas') !== null) {
                foreach ($request->get('turmas') as $turma) {
                    $matricula = new Matricula;
                    $matricula->turma_id = $turma;
                    $matricula->usuario_id = $id;
                    $matricula->save();
                }
            }

            $usuario->save();

            $qrCode = new Code();
            $qrCode->setQRUsuario($usuario->id);

            // redirect
            Session::flash('success', 'Usuário editado com sucesso!');
            return redirect($this->area);
        }
    }

    public function excluir(Request $request, $id) {
        $usuario = Usuario::find($id)->toArray();

        // redirect
        Session::flash('excluir', 'Tem certeza que deseja excluir ' . $usuario['nome'] . '?');
        Session::flash('usuario_id', $usuario['id']);
        return redirect($this->area);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        Usuario::destroy($id);

        Session::flash('success', 'Usuário movido para a lixeira.');
        return redirect($this->area);
    }

    public function consultaCEP($cep = '') {
        $cep = (!empty($_POST['cep']) ? $_POST['cep'] : $cep);

        $consulta = consultaCEP($cep);
        return $consulta;
    }

    public function carteirinha($usuario_id) {
        $usuario = Usuario::find($usuario_id);

        return view($this->area . '.carteirinha', array('usuario' => $usuario));
        $pdf = new Dompdf();
        $pdf->set_paper('A4', 'landscape');
        $pdf->load_html(view($this->area . '.carteirinha', array('usuario' => $usuario)));
        $pdf->render();

        $pdf->stream('carteirinha_' . str_replace(' ', '_', strtolower($usuario->nome)) . '.pdf');
    }

    public function consultaDados($usuario_id) {
        $usuario_id = (!empty($_POST['usuario_id']) ? $_POST['usuario_id'] : $usuario_id);

        $usuario = Usuario::find($usuario_id);
        dd($usuario);
    }

}
