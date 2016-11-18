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
                <h3 class="box-title">Caixas</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                @if(count($caixas) > 0)
                <table class="table table-striped tabData" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Data</th>
                            <th>Hora Abertura</th>
                            <th>Hora Fechamento</th>
                            <th>Saldo Inicial</th>
                            <th>Saldo Final</th>
                            <th>Total Entradas</th>
                            <th>Total Saidas</th>
                            <th>Ver</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Data</th>
                            <th>Hora Abertura</th>
                            <th>Hora Fechamento</th>
                            <th>Saldo Inicial</th>
                            <th>Saldo Final</th>
                            <th>Total Entradas</th>
                            <th>Total Saidas</th>
                            <th>Ver</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($caixas as $caixa)
                        <tr>
                            <th>{{ $caixa->id }}</th>
                            <th>{{ $caixa->data }}</th>
                            <th>{{ $caixa->hora_abertura }}</th>
                            <th>{{ $caixa->hora_fechamento == '' ? 'em aberto' : $caixa->hora_fechamento }}</th>
                            <th>{{ $caixa->saldo_inicial }}</th>
                            <th>{{ $caixa->saldo_final == '' ? 'em aberto' : $caixa->saldo_final }}</th>
                            <th>{{ $caixa->total_entradas == '' ? 'em aberto' : $caixa->saldo_final }}</th>
                            <th>{{ $caixa->total_saidas == '' ? 'em aberto' : $caixa->total_saidas }}</th>
                            <th><a href="{{ url('caixa/' . $caixa->id ) }}" title="Ver movimentação"><i class="icon fa fa-search"></i></a></th>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <h5>
                    Nenhum registro de caixa.
                </h5>
                @endif
            </div><!-- /.box-body -->
            <div class="box-footer">

            </div><!-- /.box-footer-->
        </div><!-- /.box -->
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection
