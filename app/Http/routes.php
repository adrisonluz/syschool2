<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

Route::group(['middlewareGroups' => ['web']], function () {

    Route::get('/', 'HomeController@index');

    /*     * * Usuários ** */
    Route::get('usuarios/excluir/{id}', 'UsuariosController@excluir');
    Route::post('/consultaCEP', 'UsuariosController@consultaCEP');
    Route::post('usuarios/consultaCEP', 'UsuariosController@consultaCEP');
    Route::post('usuarios/getImagemFoto', 'UsuariosController@getImagemFoto');
    Route::get('usuarios/carteirinha/{usuario_id}', 'UsuariosController@carteirinha');
    Route::resource('usuarios', 'UsuariosController');

    /*     * * Contratos ** */
    Route::get('contratos/excluir/{id}', 'ContratosController@excluir');
    Route::resource('contratos', 'ContratosController');

    /*     * * Turmas ** */
    Route::get('turmas/excluir/{id}', 'TurmasController@excluir');
    Route::post('turmas/emitir-boletos', 'TurmasController@emitirBoletos');
    Route::post('turmas/consultaByAluno', 'TurmasController@consultaByAluno');
    Route::resource('turmas', 'TurmasController');

    /*     * * Cursos ** */
    Route::get('cursos/excluir/{id}', 'CursosController@excluir');
    Route::resource('cursos', 'CursosController');

    /*     * * Modulos ** */
    Route::get('modulos/excluir/{id}', 'ModulosController@excluir');
    Route::resource('modulos', 'ModulosController');

    /*     * * Caixa ** */
    Route::get('caixa/extrato', 'CaixaController@extrato');
    Route::post('caixa/fechar/{id}', 'CaixaController@fechar');
    Route::resource('caixa', 'CaixaController');

    /*     * * Movimentação ** */
    Route::post('movimentacao/entrada', 'MovimentacaoController@entrada');
    Route::post('movimentacao/saida', 'MovimentacaoController@saida');

    /*     * * Boletos ** */
    Route::post('boletos/getMensalidade', 'BoletosController@getMensalidade');
    Route::get('boletos/excluir/{id}', 'BoletosController@excluir');
    Route::get('boletos/imprimir/{id}', 'BoletosController@printBoleto');
    Route::resource('boletos', 'BoletosController');

    /*     * * Remessa / Retorno ** */
    Route::get('remessa-retorno/create/{param}', 'RemessaRetornoController@create');
    Route::post('remessa-retorno/{param}', 'RemessaRetornoController@store');
    Route::post('remessa-retorno/ver-boletos/{id}', 'RemessaRetornoController@verBoletos');
    Route::resource('remessa-retorno', 'RemessaRetornoController');

    Route::get('/acessos/entrada/{id_usuario}', 'AcessosController@entrada');
    Route::post('acessos/entrada/{id_usuario}', 'AcessosController@entrada');
    Route::get('acessos/manual', 'AcessosController@manual');
    Route::post('acessos/manual', 'AcessosController@manualInserir');
    Route::get('/acessos', 'AcessosController@index');

    //Chamadas
    Route::get('chamadas/turma/{turma_id}', 'ChamadasController@turma');
    Route::get('chamadas/turma/{turma_id}/{data}', 'ChamadasController@turma');
    Route::resource('/chamadas', 'ChamadasController');

    //Pontos
    Route::get('pontos/usuario/{usuario_id}', 'PontosController@usuario');
    Route::get('pontos/usuario/{usuario_id}/{data}', 'PontosController@usuario');
    Route::resource('/pontos', 'PontosController');

    // Relatórios | Administrativo
    Route::get('relatorios/usuarios', 'RelatoriosController@usuarios');
    Route::post('relatorios/usuarios', 'RelatoriosController@usuariosResult');
    Route::get('relatorios/chamadas', 'RelatoriosController@chamadas');
    Route::post('relatorios/chamadas', 'RelatoriosController@chamadasResult');
    Route::get('relatorios/ponto', 'RelatoriosController@ponto');
    Route::post('relatorios/ponto', 'RelatoriosController@pontoResult');
    Route::post('relatorios/imprimir', 'RelatoriosController@imprimir');

    // Pesquisas
    Route::post('pesquisa', 'SearchController@index');
    Route::post('pesquisa/{key}', 'SearchController@searchByKey');

    // Authentication routes...
    Route::get('login', 'AuthController@getLogin');
    Route::post('login', 'AuthController@postLogin');
    Route::get('logout', 'AuthController@logout');
    Route::post('logout', 'AuthController@logout');

    // Registration routes...
    Route::get('register', 'AuthController@getRegister');
    Route::post('register', 'AuthController@postRegister');
});
