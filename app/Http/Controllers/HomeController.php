<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Usuario;
use App\Boleto;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Auth;

class HomeController extends Controller {

    public $area;

    public function __construct() {
        $this->middleware('auth');
        $this->area = 'home';
        $this->arrayReturn = array('usuarioLogado' => $this->usuarioLogado = Auth::user());

        $this->mapList = array(
            array('nome' => 'Home', 'icon' => '', 'link' => '/' . $this->area)
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $pageTitle = 'Home';

        $usuarios = Usuario::where(['lixeira' => null])->get();
        $usuariosNiver = Usuario::where(['niver' => date('d-m'), 'lixeira' => null])->get();
        $boletosVenc = Boleto::where(['status' => 'vencido', 'lixeira' => null])->get();

        // Se encontrar usuários fazendo aniversário, atualiza idade
        if(count($usuariosNiver) > 0){
            foreach($usuariosNiver as $usuarioNiver){
                $idade = getIdade(date('d/m/Y',strtotime($usuarioNiver->nascimento)));

                if($idade !== $usuarioNiver->idade){
                    $userEdit = Usuario::find($usuarioNiver->id);
                    $userEdit->idade = $idade;
                    $userEdit->save();   
                }
            }
        }

        if (Session::has('alert')) {
            $session = Session::get('alert');
        } else {
            $session = '';
        }

        $this->arrayReturn += [
            'usuarios' => $usuarios,
            'usuariosNiver' => $usuariosNiver,
            'page_title' => $pageTitle,
            'boletosVenc' => $boletosVenc,
            'mapList' => $this->mapList,
            'session' => $session,
            'usuarioLogado' => $this->usuarioLogado
        ];

        return view($this->area, $this->arrayReturn);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
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
