@extends('layout/app')

@section('content')

<div class='row'>
    <div class='col-md-12'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Versão atual <strong class="text-blue">#{{$contratoAtual->versao}}</strong></h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <table id="tabela_cadastro" class="table  table-striped" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Criação</th>
                            <th>Emissão</th>
                            <th>Versão</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Criação</th>
                            <th>Emissão</th>
                            <th>Versão</th>
                            <th>Ação</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($contratoAtual->versoes() as $contrato)
                        <tr>
                            <td>
                                {{ $contrato->id }}
                            </td>
                            <td>
                                <a href="usuarios/{{ $contrato->usuario_id }}" title="{{ $contrato->usuario->nome }} perfil ">{{ $contrato->usuario->nome }}</a>
                            </td>
                            <td>{{ $contrato->criacao }}</td>
                            <td>{{ $contrato->emissao }}</td>
                            <td>{{ $contrato->versao }}</td>
                            <td>
                                <a href="{{ url('contratos/' . $contrato->id) }}" title="Ver" ><i class="fa fa-eye"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div><!-- /.box-body -->
            <div class="box-footer">
                <a href="javascript:history.back(-1)" class="btn btn-success pull-right">Voltar</a>
            </div><!-- /.box-footer-->
        </div><!-- /.box -->
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection
