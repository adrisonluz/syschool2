@extends('layout/app')

@section('content')

<div class='row'>
    <div class='col-md-12'>
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
                @if(count($chamadas) > 0)
                <table class="table table-striped tabData" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Turma</th>
                            <th>Matrículas</th>
                            <th>Registros</th>
                            <th>Data</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Turma</th>
                            <th>Matrículas</th>
                            <th>Registros</th>
                            <th>Data</th>
                            <th>Ação</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($chamadas as $chamada)
                        <tr>
                            <td>
                                <strong class="text-green">{{ $chamada['turma']->curso->nome }} | {{ $chamada['turma']->modulo->nome }} | {{ $chamada['turma']->professor->nome }}</strong>
                            </td>
                            <td>
                                {{count($chamada['turma']->alunos)}}
                            </td>
                            <td>
                                {{$chamada["numRegistros"]}}
                            </td>
                            <td>
                                {{$chamada["dataRegistros"]}}
                            </td>
                            <td>
                                <a href="{{url('/chamadas/turma/' . $chamada['turma']->id)}}" title="Todos os registros da turma"><i class="fa fa-search-plus"></i></a>
                                <a href="{{url('/chamadas/turma/' . $chamada['turma']->id . '/' . (str_replace('/','-',$chamada['dataRegistros'])))}}" title="Ver registros em {{$chamada['dataRegistros']}}"><i class="fa fa-search"></i></a>
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