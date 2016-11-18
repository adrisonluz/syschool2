@extends('layout.app')

@section('content')
<div class='row'>
    <div class='col-md-12'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Bem vindo {{ $usuarioLogado->nome }}!</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
            </div>
            <div class="box-footer">

            </div><!-- /.box-footer-->
        </div><!-- /.box -->
    </div>

    @if(count($usuariosNiver) > 0)
    <div class='col-md-12'>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Aniversariantes do dia:</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    @foreach($usuariosNiver as $niver)
                    <div class="col-lg-4 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-fuchsia-active">
                            <div class="inner">
                                <h3>{{ $niver->nome }}</h3>
                                <p>{{ $niver->idade }} anos</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-birthday-cake"></i>
                            </div>
                            <a href="{{ url('usuarios/' . $niver->id) }}" class="small-box-footer">
                                Ver perfil <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div><!-- /.box-body -->
            <div class="box-footer">

            </div><!-- /.box-footer-->
        </div><!-- /.box -->
    </div><!-- /.col -->
    @endif

    @if(count($boletosVenc) > 0)
    <div class='col-md-12'>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Boletos vencidos:</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-striped" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Referência</th>
                            <th>Usuário</th>
                            <th>Competência</th>
                            <th>Valor</th>
                            <th>Data Venc.</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Referência</th>
                            <th>Usuário</th>
                            <th>Competência</th>
                            <th>Valor</th>
                            <th>Data Venc.</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($boletosVenc as $boleto)
                        <tr>
                            <td>{{ $boleto->id }}</td>
                            <td>{{ $boleto->referencia }}</td>
                            <td><a href="{{ url('usuarios/' . $boleto->usuario->id) }}" class="small-box-footer">{{ $boleto->usuario->nome }}</a></td>
                            <td>{{ $boleto->competencia }}</td>
                            <td>{{ $boleto->valor }}</td>
                            <td class="danger">{{ $boleto->data_vencimento }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div><!-- /.box -->
        </div><!-- /.col -->
        @endif
    </div><!-- /.row -->
    @endsection
