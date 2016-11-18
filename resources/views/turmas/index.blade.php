@extends('layout/app')

@section('content')

@if(Session::has('excluir'))
<div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-check"></i> Atenção!</h4>

    <form action="{{ url('turmas/' . Session::get('turma_id')) }}" method="POST">
        <div class="row">
            <div class="form-group col-md-10">
                {!! csrf_field() !!}
                {!! method_field('DELETE') !!}

                <label>
                    {{ Session::get('excluir') }}
                </label>
            </div>

            <div class="form-group col-md-2">
                <a href='{{ url('turmas') }}' class="btn btn-info">
                    <i class="fa fa-close"></i> Não
                </a>
                &nbsp;
                <button type="submit" class="btn btn-danger">
                    <i class="fa fa-trash"></i> Sim
                </button>
            </div>
        </div>
    </form>
</div>
@endif

@if(Session::has('success'))
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-check"></i> Sucesso!</h4>
    {{Session::get('success')}}
</div>
@endif

@if(Session::has('error'))
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-ban"></i> Ops! Algo não está certo.</h4>
    {{Session::get('error')}}
</div>
@endif


@if (count($errors) > 0)
@foreach ($errors->all() as $error)
<div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-warning"></i> Alerta:</h4>
    {{ $error }}
</div>
@endforeach
@endif

<div class='row'>
    <div class='col-md-6'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Turmas</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                @if(count($turmas) > 0)
                <table class="table table-striped tabData" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Turma</th>
                            <th>Dias</th>
                            <th>Vagas</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Turma</th>
                            <th>Dias</th>
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
                                <a href="turmas/{{ $turma->id }}" title="{{ $turma->curso->nome }} | {{ $turma->professor->nome }}">{{ $turma->curso->nome }} | {{ $turma->modulo->nome }} | {{ $turma->professor->nome }}</a>
                            </td>
                            <td>
                                {{ $turma->dias }}
                            </td>
                            <td>
                                {{ $turma->vagas - (count($turma->alunos)) }}
                            </td>
                            <td>
                                <a href="{{ url('turmas/' . $turma->id . '/edit/') }}" title="Editar" ><i class="fa fa-edit"></i></a>
                                <a href="{{ url('turmas/excluir/' . $turma->id) }}" title="Excluir" ><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <h5>
                    Nenhuma turma cadastrada.
                </h5>
                @endif
            </div><!-- /.box-body -->
            <div class="box-footer">

            </div><!-- /.box-footer-->
        </div><!-- /.box -->
    </div><!-- /.col -->
    <div class='col-md-6'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Cursos</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                @if(count($cursos) > 0)
                <table class="table table-striped" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Qtd de aulas</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tfoot>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Qtd de aulas</th>
                    <th>Ação</th>
                    </tfoot>
                    <tbody>
                        @foreach($cursos as $curso)
                        <tr>
                            <td>
                                {{ $curso->id }}
                            </td>
                            <td>
                                <a href="cursos/{{ $curso->id }}" title="{{ $curso->nome }}">{{ $curso->nome }}</a>
                            </td>
                            <td>
                                {{ $curso->qtd_aulas }}
                            </td>
                            <td>
                                <a href="{{ url('cursos/' . $curso->id . '/edit/') }}" title="Editar" ><i class="fa fa-edit"></i></a>
                                <a href="{{ url('cursos/excluir/' . $curso->id) }}" title="Excluir" ><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <h5>
                    Nenhuma turma cadastrada.
                </h5>
                @endif
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->

    <div class='col-md-6'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Módulos</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                @if(count($modulos) > 0)
                <table class="table table-striped" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Curso</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Curso</th>
                            <th>Ação</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($modulos as $modulo)
                        <tr>
                            <td>
                                {{ $modulo->id }}
                            </td>
                            <td>
                                <a href="modulos/{{ $modulo->id }}" title="{{ $modulo->nome }}">{{ $modulo->nome }}</a>
                            </td>
                            <td>
                                {{ $modulo->curso->nome }}
                            </td>
                            <td>
                                <a href="{{ url('modulos/' . $modulo->id . '/edit/') }}" title="Editar" ><i class="fa fa-edit"></i></a>
                                <a href="{{ url('modulos/excluir/' . $modulo->id) }}" title="Excluir" ><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <h5>
                    Nenhum módulo cadastrado.
                </h5>
                @endif
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection
