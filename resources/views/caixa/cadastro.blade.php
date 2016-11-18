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

<div class='row'>
    <div class='col-md-5'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Abrir Caixa</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ url('/caixa') }}" method="post">
                {!! csrf_field() !!}
                <div class="box-body">
                    <div class="form-group col-md-6">
                      <label>Data</label>
                      <input class="form-control" value="{{ date('d/m/Y') }}" disabled="" type="text">
                      <input type="hidden" name="data" value="{{ date('d/m/Y') }}" />
                      <input type="hidden" name="caixa_id" value="{{ !empty($caixaMae) ? $caixaMae->id : '' }}" />
                    </div>
                    <div class="form-group col-md-6">
                      <label>Hora da abertura</label>
                      <input class="form-control" name="hora_abertura" value="{{ date('H:i') }}" type="text">
                    </div>
                    <div class="form-group col-md-12">
                      <label>Saldo inicial R$</label>
                      <input class="form-control formDin" name="saldo_inicial" type="text">
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right">Abrir Caixa</button>
                </div>
            </form>
        </div>
    </div>

    @if(count($caixasHoje) > 0)
    <div class='col-md-7'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Caixas no dia de hoje</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <table class="table table-striped tabData" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Saldo inicial</th>
                            <th>Saldo final</th>
                            <th>Entradas</th>
                            <th>Saídas</th>
                            <th>Fechamento</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Saldo inicial</th>
                            <th>Saldo final</th>
                            <th>Entradas</th>
                            <th>Saídas</th>
                            <th>Fechamento</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($caixasHoje as $caixaHoje)
                        <tr>
                            <th>{{ $caixaHoje->saldo_inicial }}</th>
                            <th>{{ $caixaHoje->saldo_final == '' ? 'em aberto' : $caixaHoje->saldo_final }}</th>
                            <th>{{ $caixaHoje->total_entradas == '' ? 'em aberto' : $caixaHoje->saldo_final }}</th>
                            <th>{{ $caixaHoje->total_saidas == '' ? 'em aberto' : $caixaHoje->total_saidas }}</th>
                            <th>{{ $caixaHoje->hora_fechamento == '' ? 'em aberto' : $caixaHoje->hora_fechamento }}</th>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div><!-- /.col -->
    @endif
</div><!-- /.row -->
@endsection
