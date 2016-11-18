@extends('layout/app')

@section('content')

<div class='row'>
    <div class='col-md-12'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Ponto</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                @if(count($pontos) > 0)
                <table class="table table-striped tabData" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Usuário</th>
                            <th>Ultimo registro Tipo - Hora - Data</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Usuário</th>
                            <th>Ultimo registro Tipo - Hora - Data</th>
                            <th>Ação</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($pontos as $ponto)
                        <tr>
                            <td><a href="{{url('/usuarios/' . $ponto['usuario']->id) }}" title="Ver perfil">{{ $ponto['usuario']->nome }}</a></td>
                            <td>{{ $ponto['tipoRegistros'] }} - {{ $ponto['horaRegistros'] }} - {{ $ponto['dataRegistros'] }}</td>
                            <td>
                                <a href="{{url('/pontos/usuario/' . $ponto['usuario']->id)}}" title="Todos os registros do usuário"><i class="fa fa-search-plus"></i></a>
                                <a href="{{url('/pontos/usuario/' . $ponto['usuario']->id . '/' . (str_replace('/','-',$ponto['dataRegistros'])))}}" title="Ver registros em {{$ponto['dataRegistros']}}"><i class="fa fa-search"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <h5>
                    Nenhuma chamada encontrada.
                </h5>
                @endif
            </div><!-- /.box-body -->
            <div class="box-footer">

            </div><!-- /.box-footer-->
        </div><!-- /.box -->
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection