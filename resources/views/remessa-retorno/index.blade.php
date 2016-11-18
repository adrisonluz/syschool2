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
            <div class="box-header with-border">
                <h3 class="box-title">Remessas emitidas</h3>
                {!! csrf_field() !!}
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                @if(count($remessas) > 0)
                <table id="tabela_cadastro" class="table  table-striped" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Emissão</th>
                            <th>Qtd Boletos</th>
                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Emissão</th>
                            <th>Qtd Boletos</th>
                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($remessas as $remessa)
                        <tr>
                            <td>{{ $remessa->id }}</td>
                            <td>{{ date('d/m/Y', strtotime($remessa->data_geracao)) }}</td>
                            <td>{{ count($remessa->boletos) }}</td>
                            <td>{{ $remessa->status }}</td>
                            <td>
                                <a href="{{ url('remessa-retorno/ver-boletos/' . $remessa->id) }}" title="Ver boletos" rel="{{$remessa->id}}" class="verBoletosRemessaRetorno" data-toggle="modal" data-target="#modalBoletos"><i class="fa fa-search"></i></a>
                                @if($remessa->status == 'aguardando')
                                <a href="{{ url('remessa-retorno/enviar-remessa/' . $remessa->id) }}" title="Enviar remessa"><i class="fa fa-print"></i></a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <h5>
                    Nenhuma remessa encontrada.
                </h5>
                @endif
            </div><!-- /.box-body -->
            <div class="box-footer">
                <a href="{{ url('remessa-retorno/create/remessa') }}" class="btn btn-success pull-right">Gerar nova remessa</a>
            </div><!-- /.box-footer-->
        </div><!-- /.box -->
    </div><!-- /.col -->

    <div class='col-md-12'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Retornos registrados</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                @if(count($retornos) > 0)
                <table id="tabela_cadastro" class="table  table-striped" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Data de emissão</th>
                            <th>Qtd Boletos</th>
                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Data de emissão</th>
                            <th>Qtd Boletos</th>
                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($retornos as $retorno)
                        <tr>
                            <td>{{ $retorno->id }}</td>
                            <td>{{ $retorno->data_geracao }}</td>
                            <td>{{ count($retorno->boletos) }}</td>
                            <td>{{ $retorno->status }}</td>
                            <td>
                                <a href="{{ url('remessa-retorno/ver-boletos/' . $retorno->id) }}" title="Ver boletos" rel="{{$retorno->id}}" class="verBoletosRemessaRetorno" data-toggle="modal" data-target="#modalBoletos"><i class="fa fa-search"></i></a>
                                @if($retorno->status == 'aguardando')
                                <a href="{{ url('remessa-retorno/enviar-retorno/' . $retorno->id) }}" title="Enviar retorno"><i class="fa fa-print"></i></a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <h5>
                    Nenhum retorno encontrado.
                </h5>
                @endif
            </div><!-- /.box-body -->
            <div class="box-footer">
                <a href="{{ url('remessa-retorno/create/retorno') }}" class="btn btn-success pull-right">Registrar novo retorno</a>
            </div><!-- /.box-footer-->
        </div><!-- /.box -->
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection

<div class="modal fade" id="modalBoletos" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">×</span></button>
                <h3 class="box-title">Boletos relacionados</h3>
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
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
