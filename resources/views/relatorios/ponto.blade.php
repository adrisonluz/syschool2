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
            <form role="form" action="{{ url('/relatorios/ponto') }}" method="post">
                <div class="box-body">
                    {!! csrf_field() !!}
                    <div class="box-body">  
                        <h3 class="box-title">Buscar por</h3>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Funcionário</label>
                                <select name="busca_func" class="form-control select2">
                                    <option value="">Todos</option>
                                    @if(count($funcionarios) > 0)
                                    @foreach($funcionarios as $funcionario)
                                    <option value="{{$funcionario->id}}">{{$funcionario->nome}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label>Tipo</label>
                                <select name="busca_tipo" class="form-control">
                                    <option value="">Entrada/Saída</option>
                                    <option value="entrada">Entrada</option>
                                    <option value="saida">Saída</option>
                                </select>
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label>Ações</label>
                                <select name="busca_acao" class="form-control">
                                    <option value="">Nenhuma</option>
                                    <option value="calc_horas">Calc. Horas</option>
                                </select>
                            </div>
                        </div>
                        
                        <h3 class="box-title">Exibir</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group col-md-3">
                                    <label>
                                        <input class="minimal" name="usuario_id" type="checkbox">
                                        Funcionário
                                    </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>
                                        <input class="minimal" name="data" type="checkbox">
                                        Data
                                    </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>
                                        <input class="minimal" name="hora" type="checkbox">
                                        Hora
                                    </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>
                                        <input class="minimal" name="tipo" type="checkbox">
                                        Tipo
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group col-md-6">
                                    <label for="cadastro">De </label>
                                    <input class="form-control formDate" name="periodo_de">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="cadastro">Até </label>
                                    <input class="form-control formDate" name="periodo_ate">
                                </div>
                            </div>    
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="form-group col-md-10">
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
