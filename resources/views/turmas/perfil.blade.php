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
                <img class="profile-user-img img-responsive img-circle" src="{{ asset('assets/img/turma.png') }}" alt="{{ $turma->curso->nome }} | {{ $turma->professor->nome }}">
                <h3 class="profile-username text-center">{{ $turma->modulo->nome }} | {{ $turma->curso->nome }}</h3>
                <p class="text-muted text-center">{{ $turma->professor->nome }}</p>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>Dias:</b> <a class="pull-right">{{ $turma->dias }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Horários:</b> 
                        @if(count($turma->horarios) > 0)
                        @foreach($turma->horarios as $horario)
                        <br><b>{{ ($horario->dia_semana == 'mon' ? 'Seg' : ($horario->dia_semana == 'tue' ? 'Ter' : ($horario->dia_semana == 'wed' ? 'Qua' : ($horario->dia_semana == 'thu' ? 'Qui' : ($horario->dia_semana == 'fri' ? 'Sex' : ($horario->dia_semana == 'sat' ? 'Sab' : '')))))) }}</b> 
                        {{ $horario->hora_inicio }} - {{ $horario->hora_fim }}
                        @endforeach
                        @else
                        Sem registros
                        @endif
                    </li>
                    <li class="list-group-item">
                        <b>Vagas:</b> <a class="pull-right">{{ $turma->vagas }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Aulas dadas:</b> <a class="pull-right">{{ $turma->aulas_dadas }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Valor da mensalidade:</b> <a class="pull-right">{{ $turma->mensalidade }}</a>
                        <br/>
                    </li>
                </ul>
                <a href="{{ url('turmas/' . $turma->id . '/edit') }}" class="btn btn-primary btn-block"><b>Editar</b></a>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->

    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#alunos" data-toggle="tab">Alunos matriculados</a></li>
                <li><a href="#agenda" data-toggle="tab">Agenda</a></li>
                <!--li><a href="#gestao" data-toggle="tab">Gestão</a></li-->
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="alunos">
                    @if(count($turma->alunos) > 0)
                    <table class="table table-striped tabData" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Status</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Status</th>
                                <th>Ação</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($turma->alunos as $aluno)
                            <tr>
                                <td>
                                    {{ $aluno->id }}
                                </td>
                                <td>
                                    <a href="usuarios/{{ $aluno->id }}" title="{{ $aluno->nome }}">{{ $aluno->nome }}</a>
                                </td>
                                <td>
                                    boleto_status
                                </td>
                                <td>
                                    <a href="{{ url('usuarios/' . $aluno->id . '/edit/') }}" title="Editar" ><i class="fa fa-edit"></i></a>
                                    <a href="{{ url('usuarios/excluir/' . $aluno->id) }}" title="Excluir" ><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <h5>
                        Nenhum aluno matriculado.
                    </h5>
                    @endif
                </div><!-- /.tab-pane -->

                <div class="tab-pane" id="agenda">

                </div><!-- /.tab-pane -->

                <div class="tab-pane" id="gestao">
                    <h3 class="box-title">Financeiro</h3>

                    <div class="row">
                        <div class="col-md-4"></div>

                        <div class="col-md-4"></div>

                        <div class="col-md-4">
                            {!! csrf_field() !!}
                            <input type="hidden" value="{{ $turma->id }}" class="turma_id" />
                            <button class="btn btn-success btn-block btnEmitirBoletorTurma" data-toggle="modal" data-target="#modalBoletos"><b>Emitir boletos da turma</b></button>
                        </div>
                    </div>
                </div><!-- /.tab-pane -->
            </div><!-- /.tab-content -->
        </div><!-- /.nav-tabs-custom -->
    </div><!-- /.col -->

    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Registro de chamada</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                @if(count($turma->chamadas) > 0)   
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
                        @foreach($turma->chamadas as $chamada)
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
                <a href="{{ url('relatorios/chamadas')}}" class="btn btn-success pull-right">Relatório</a>
            </div>
        </div><!-- /.box -->
    </div><!-- /.col -->

</div><!-- /.row -->
@endsection

<div class="modal fade modalSaida" id="modalBoletos" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">×</span></button>
                <h3 class="box-title">Boletos relacionados com a turma <strong>{{ $turma->curso->nome }} | {{ $turma->professor->nome }}</strong></h3>
            </div>
            <div class="modal-body">
                <table class="table table-striped" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Valor</th>
                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <a href="{{ url('turmas/imprimir-boletos/' . $turma->id) }}" class="btn btn-primary btn-block btnImprimirBoletorTurma"><b>Imprimir todos</b></a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
