@extends('layout/app')

@section('content')

@if (count($errors) > 0)
@foreach ($errors->all() as $error)
<div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-warning"></i> Alerta:</h4>
    {{ $error }}
</div>
@endforeach
@endif
<div class="row">
    <div class="col-md-3">

        <!-- Profile Image -->
        <div class="box box-primary">
            <div class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" src="{{ asset($usuario->foto == '' ? '/assets/img/default.png' : 'perfil/' . $usuario->foto ) }}" alt="User profile picture">
                <h3 class="profile-username text-center">{{ $usuario->nome }}</h3>
                <p class="text-muted text-center">{{ $usuario->nivel }}</p>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>Nascimento</b> <a class="pull-right">{{ data($usuario->nascimento) }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Idade</b> <a class="pull-right">{{ $usuario->idade }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Matrícula</b> <a class="pull-right">{{ $usuario->id }}</a>
                    </li>
                </ul>

                <a href="{{ url('usuarios/' . $usuario->id . '/edit') }}" class="btn btn-primary btn-block"><b>Editar</b></a>
                <a href="{{ url('usuarios/carteirinha/' . $usuario->id ) }}" class="btn btn-success btn-block" target="new"><b>Download Carteirinha</b></a>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

        <!-- About Me Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Emergência</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <strong>Em caso de emergência ligar para:</strong>
                <p class="text-muted">{{ $usuario->emerg_nome }} - {{ $usuario->emerg_telefone }}</p>
                <hr>
                <strong>Possui algum problema de saúde?</strong>
                <p class="text-muted">{{ $usuario->problema_saude }}</p>
                <hr>
                <strong>Possui alguma alergia?</strong>
                <p class="text-muted">{{ $usuario->alergia }}</p>
                <hr>
                <strong>Toma algum medicamento?</strong>
                <p class="text-muted">{{ $usuario->medicamento }}</p>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#geral" data-toggle="tab">Geral</a></li>
                <li><a href="#financeiro" data-toggle="tab">Financeiro</a></li>
                @if($usuario->nivel == 'aluno' || $usuario->nivel == 'aluno_prof')
                <li><a href="#chamadas" data-toggle="tab">Chamadas</a></li>
                @endif
                @if($usuario->nivel == 'aluno_prof' || $usuario->nivel == 'prof_func' || $usuario->nivel == 'sec')
                <li><a href="#pontos" data-toggle="tab">Ponto</a></li>
                @endif
                <li><a href="#agenda" data-toggle="tab">Agenda</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="geral">
                    <table class="table dataTable table-bordered">
                        <tr>
                            <th>Endereço</th> <td>{{ $usuario->endereco }}</td>
                            <th>Nome pai</th> <td>{{ $usuario->nome_pai }}</td>
                        </tr>
                        <tr>
                            <th>Bairro/Cidade</th> <td>{{ $usuario->bairro }} / {{ $usuario->cidade }}</td>
                            <th>Celular pai</th> <td>{{ $usuario->cel_pai }}</td>
                        </tr>
                        <tr>
                            <th>CEP</th> <td>{{ $usuario->cep }}</td>
                            <th>Nome mãe</th> <td>{{ $usuario->nome_mae }}</td>
                        </tr>
                        <tr>
                            <th>RG</th> <td>{{ $usuario->rg }}</td>
                            <th>Celular mãe</th> <td>{{ $usuario->cel_mae }}</td>
                        </tr>
                        <tr>
                            <th>CPF</th> <td>{{ $usuario->cpf }}</td>
                            <th>Outro responsável</th> <td>{{ $usuario->nome_outro }}</td>
                        </tr>
                        <tr>
                            <th>Telefone res</th> <td>{{ $usuario->telefone }}</td>
                            <th>Celular</th> <td>{{ $usuario->cel_outro }}</td>
                        </tr>
                        <tr>
                            <th>Celular</th> <td>{{ $usuario->celular }}</th>
                            <th>Vinculo</th> <td>{{ $usuario->vinculo }}</td>
                        </tr>
                        <tr>
                            <th>Email</th> <td>{{ $usuario->email }}</td>
                            <th></th> <td></td>
                        </tr>
                    </table>
                </div><!-- /.tab-pane -->

                <div class="tab-pane" id="financeiro">
                    <table class="table dataTable table-bordered">
                        <tr>
                            <th>Boletos em nome de</th> <td>{{ $usuario->nome_boleto }}</td>
                        </tr>
                        <tr>
                            <th>CPF emitido nos boletos</th> <td>{{ $usuario->cpf_boleto }}</td>
                        </tr>
                        <tr>
                            <th>Desconto</th> <td>{{ $usuario->desconto }}</td>
                        </tr>
                        <tr>
                            <th>Nome do banco</th> <td>{{ $usuario->nome_banco }}</td>
                        </tr>
                        <tr>
                            <th>Agência</th> <td>{{ $usuario->agencia_banco }}</td>
                        </tr>
                        <tr>
                            <th>N° da conta</th> <td>{{ $usuario->conta_banco }}</td>
                        </tr>
                    </table>
                </div><!-- /.tab-pane -->

                @if($usuario->nivel == 'aluno' || $usuario->nivel == 'aluno_prof')
                <div class="tab-pane" id="chamadas">
                    <div class="box-header with-border">
                        <h3 class="box-title text-blue">Registro de chamadas</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        @if(count($usuario->chamadas) > 0)   
                        <table id="tabela_cadastro" class="table  table-striped" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Turma</th>
                                    <th>Hora</th>
                                    <th>Data</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Turma</th>
                                    <th>Hora</th>
                                    <th>Data</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($usuario->chamadas as $chamada)
                                <tr>
                                    <td>{{ $chamada->id }}</td>
                                    <td>{{ $chamada->turma->curso->nome }} | {{ $chamada->turma->modulo->nome }} | {{ $chamada->turma->professor->nome }}</td>
                                    <td>{{ $chamada->hora }}</td>
                                    <td>{{ $chamada->data }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <h5>
                            Nenhum registro encontrado.
                        </h5>
                        @endif
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <a href="{{ url('relatorios/chamadas/' . $usuario->id)}}" class="btn btn-success pull-right">Relatório</a>
                    </div>
                </div><!-- /.tab-pane -->
                @endif

                @if($usuario->nivel == 'aluno_prof' || $usuario->nivel == 'prof_func' || $usuario->nivel == 'sec')
                <div class="tab-pane" id="pontos">
                    <div class="box-header with-border">
                        <h3 class="box-title text-blue">Registro de ponto</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        @if(count($usuario->pontos) > 0)   
                        <table id="tabela_cadastro" class="table  table-striped" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Turma</th>
                                    <th>Hora</th>
                                    <th>Data</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Tipo</th>
                                    <th>Hora</th>
                                    <th>Data</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($usuario->pontos as $ponto)
                                <tr>
                                    <td>{{ $ponto->id }}</td>
                                    <td>{{ $ponto->tipo }}</td>
                                    <td>{{ $ponto->hora }}</td>
                                    <td>{{ $ponto->data }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <h5>
                            Nenhum registro encontrado.
                        </h5>
                        @endif
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <a href="{{ url('relatorios/pontos/' . $usuario->id)}}" class="btn btn-success pull-right">Relatório</a>
                    </div>
                </div><!-- /.tab-pane -->
                @endif

                <div class="tab-pane" id="agenda">
                    <div id="calendar"></div>
                </div><!-- /.tab-pane -->
            </div><!-- /.tab-content -->
        </div><!-- /.nav-tabs-custom -->
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection
