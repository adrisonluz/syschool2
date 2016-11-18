<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Usuario;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Auth;

class SearchController extends Controller {

    public $area;

    public function __construct() {
        $this->middleware('auth');
        $this->area = 'pesquisa';
        $this->arrayReturn = array('usuarioLogado' => $this->usuarioLogado = Auth::user());

        $this->mapList = array(
            array('nome' => 'Pesquisa', 'icon' => 'fa-user', 'link' => '/' . $this->area)
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $pageTitle = 'Pesquisa';
        $chave = $_POST['key'];

        if (Session::has('alert')) {
            $session = Session::get('alert');
        } else {
            $session = '';
        }

        $key = $_POST['key'];
        $returnResult = array();

        $getNome = $this->search($key, 'Nome', 'nome');
        if ($getNome) {
            foreach ($getNome as $nome) {
                $returnResult[] = $nome;
            }
            unset($getNome);
        }

        $getCPF = $this->search($key, 'CPF', 'cpf');
        if ($getCPF) {
            foreach ($getCPF as $cpf) {
                $returnResult[] = $cpf;
            }
            unset($getCPF);
        }

        $getCPFBoletos = $this->search($key, 'CPF Boletos', 'cpf_boleto');
        if ($getCPFBoletos) {
            foreach ($getCPFBoletos as $cpfBoleto) {
                $returnResult[] = $cpfBoleto;
            }
            unset($getCPFBoletos);
        }

        $getNomePai = $this->search($key, 'Nome do pai', 'nome_pai');
        if ($getNomePai) {
            foreach ($getNomePai as $nomePai) {
                $returnResult[] = $nomePai;
            }
            unset($getNomePai);
        }

        $getNomeMae = $this->search($key, 'Nome da mãe', 'nome_mae');
        if ($getNomeMae) {
            foreach ($getNomeMae as $nomeMae) {
                $returnResult[] = $nomeMae;
            }
            unset($getNomeMae);
        }

        $getNomeOutro = $this->search($key, 'Nome ', 'nome_outro');
        if ($getNomeOutro) {
            foreach ($getNomeOutro as $nomeOutro) {
                $returnResult[] = $nomeOutro;
            }
            unset($getNomeOutro);
        }

        $this->arrayReturn += [
            'retorno' => $returnResult,
            'chave' => $chave,
            'page_title' => $pageTitle,
            'mapList' => $this->mapList,
            'session' => $session
        ];

        return view($this->area . '.index', $this->arrayReturn);
    }

    public function search($key, $campoNome, $campoTab) {
        $searchUsuarios = Usuario::select('id', 'nome', $campoTab)->where($campoTab, 'like', '%' . $key . '%')->get()->toArray();
        if ($searchUsuarios) {
            foreach ($searchUsuarios as $usuario) {
                $result[] = [
                    'id' => $usuario['id'],
                    'nome' => $usuario['nome'],
                    'campo' => $campoNome,
                    'valor' => str_replace(strtolower($key), '<span class="text-maroon text-uppercase text-bold">' . strtolower($key) . '</span> ', strtolower($usuario[$campoTab])),
                ];
            }
            return $result;
            unset($searchUsuarios);
            unset($result);
        }
    }

}
