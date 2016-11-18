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
                <img class="profile-user-img img-responsive img-circle" src="{{ asset('assets/img/modulo.png') }}" alt="{{ $modulo->nome }}">
                <h3 class="profile-username text-center">{{ $modulo->nome }}</h3>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>Curso:</b> <a class="pull-right">{{ $modulo->curso->nome }}</a>
                    </li>
                </ul>

                <a href="{{ url('modulos/' . $modulo->id . '/edit') }}" class="btn btn-primary btn-block"><b>Editar</b></a>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->

    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#turmas" data-toggle="tab">Turmas relacionadas</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="turmas">
                    <table class="table table-striped tabData" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Turma</th>
                                <th>Vagas</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Turma</th>
                                <th>Vagas</th>
                                <th>Ação</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($turmas as $turma)
                            <tr>
                                <td>
                                    {{ $turma->id }}
                                </td>
                                <td>
                                    <a href="turmas/{{ $turma->id }}" title="{{ $turma->curso->nome }} | {{ $turma->professor->nome }}">{{ $turma->curso->nome }} | {{ $turma->professor->nome }}</a>
                                </td>
                                <td>
                                    {{ $turma->vagas }}
                                </td>
                                <td>
                                    <a href="{{ url('turmas/' . $turma->id . '/edit/') }}" title="Editar" ><i class="fa fa-edit"></i></a>
                                    <a href="{{ url('turmas/excluir/' . $turma->id) }}" title="Excluir" ><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- /.tab-pane -->

            </div><!-- /.tab-content -->
        </div><!-- /.nav-tabs-custom -->
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection
