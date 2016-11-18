@extends('layout/app')

@section('content')

@if(Session::has('excluir'))
<div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-check"></i> Atenção!</h4>

    <form action="{{ url('boletos/' . Session::get('boleto_id')) }}" method="POST">
        <div class="row">
            <div class="form-group col-md-10">
                {!! csrf_field() !!}
                {!! method_field('DELETE') !!}

                <label>
                    {{ Session::get('excluir') }}
                </label>
            </div>

            <div class="form-group col-md-2">
                <a href='{{ url('boletos') }}' class="btn btn-info">
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
    @if(Session::has('boleto_id'))
    <div class="form-group col-md-2">
        <a href='{{ url('boletos/imprimir/' . Session::get('boleto_id') ) }}' class="btn btn-info" target="_blank">
            <i class="fa fa-print"></i> Imprimir
        </a>
    </div>
    @endif
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
                <h3 class="box-title">Boletos registrados</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                @if(count($boletos) > 0)
                <table id="tabela_cadastro" class="table  table-striped" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Seq</th>
                            <th>Nome</th>
                            <th>Valor</th>
                            <th>Competência</th>
                            <th>Referência</th>
                            <th>Vencimento</th>
                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Seq</th>
                            <th>Nome</th>
                            <th>Valor</th>
                            <th>Competência</th>
                            <th>Referência</th>
                            <th>Vencimento</th>
                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($boletos as $boleto)
                        <tr>
                            <td>{{ $boleto->sequencial }}</td>
                            <td>{{ $boleto->usuario_id == 0 ? 'Outros' : $boleto->usuario->nome }}</td>
                            <td>{{ $boleto->valor }}</td>
                            <td>{{ $boleto->competencia }}</td>
                            <td>{{ $boleto->referencia }}</td>
                            <td>{{ $boleto->data_vencimento }}</td>
                            <td>{{ $boleto->status }}</td>
                            <td>
                                <a href="{{ url('boletos/imprimir/' . $boleto['id']) }}" title="Imprimir" target="new"><i class="fa fa-print"></i></a>
                                @if ($boleto->status !== 'pago' && $boleto->remessa_retorno_id == null)
                                <a href="{{ url('boletos/' . $boleto['id'] . '/edit/') }}" title="Editar" ><i class="fa fa-edit"></i></a>
                                <a href="{{ url('boletos/excluir/' . $boleto['id']) }}" title="Excluir" ><i class="fa fa-trash"></i></a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <h5>
                    Nenhum boleto cadastrado.
                </h5>
                @endif
            </div><!-- /.box-body -->
            <div class="box-footer">
                <a href="{{ url('boletos/create') }}" class="btn btn-success pull-right">Novo boleto</a>
            </div><!-- /.box-footer-->
        </div><!-- /.box -->
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection