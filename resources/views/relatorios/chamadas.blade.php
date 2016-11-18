@extends('layout/app')

@section('content')

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
    <div class='col-md-12'>
        <!-- Box -->
        <div class="box box-primary">
            <form role="form" action="{{ url('/relatorios/chamadas') }}" method="post">
                <div class="box-body">
                    {!! csrf_field() !!}
                    <div class="box-body">  
                        <h3 class="box-title">Buscar por</h3>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Alunos</label>
                                <select name="busca_aluno" class="form-control select2">
                                    <option value="">Todos</option>
                                    @if(count($alunos) > 0)
                                    @foreach($alunos as $aluno)
                                    <option value="{{$aluno->id}}">{{$aluno->nome}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label>Turmas</label>
                                <select name="busca_turma" class="form-control select2">
                                    <option value="">Todas</option>
                                    @if(count($turmas) > 0)
                                    @foreach($turmas as $turma)
                                    <option value="{{$turma->id}}">{{$turma->modulo->nome}} - {{$turma->curso->nome}} - {{$turma->professor->nome}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        
                        <h3 class="box-title">Exibir</h3>
                        <div class="row">
                            <div class="form-group col-md-1">
                                <label>
                                    <input class="minimal" name="usuario_id" type="checkbox">
                                    Aluno
                                </label>
                            </div>
                            <div class="form-group col-md-1">
                                <label>
                                    <input class="minimal" name="turma_id" type="checkbox">
                                    Turma
                                </label>
                            </div>
                            <div class="form-group col-md-1">
                                <label>
                                    <input class="minimal" name="data" type="checkbox">
                                    Data
                                </label>
                            </div>
                            <div class="form-group col-md-1">
                                <label>
                                    <input class="minimal" name="hora" type="checkbox">
                                    Hora
                                </label>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="form-group col-md-2">
                        <label for="cadastro">De </label>
                        <input class="form-control formDate" name="periodo_de">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="cadastro">Até </label>
                        <input class="form-control formDate" name="periodo_ate">
                    </div>
                    <div class="form-group col-md-6">
                    </div>
                    <div class="form-group col-md-2">
                        <br>
                        <button type="submit" class="btn btn-primary">Gerar relatório</button>
                    </div>
                </div>
            </form>
        </div><!-- /.box -->
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection
