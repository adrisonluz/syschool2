@extends('layout/app')

@section('content')

<div class='row'>
    @if($data !== '')
    <div class='col-md-12'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title text-blue">{{ $turma->curso->nome }} | {{ $turma->modulo->nome }} | {{ $turma->professor->nome }}</h3>
                <span class='pull-right text-green'>{{ $data }}</span>
            </div>
            <div class="box-body">                
                <table class="table table-striped tabData" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Aluno</th>
                            <th>Hora</th>
                            <th>Data</th>
                            <th>Justificativa</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Aluno</th>
                            <th>Hora</th>
                            <th>Data</th>
                            <th>Justificativa</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($registros as $registro)
                        <tr>
                            <td>{{ $registro->id }}</td>
                            <td><a href="{{ url('/usuarios/' . $registro->aluno->id)}} " title="Ver pefil">{{ $registro->aluno->nome }}</a></td>
                            <td>{{ $registro->hora }}</td>
                            <td>{{ $registro->data }}</td>
                            <td>{{ $registro->justificativa }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div><!-- /.box-body -->
            <div class="box-footer">
                <a href="{{url('chamadas/turma/' . $turma->id )}}" title="Voltar" class="btn btn-success pull-right">Voltar</a>
            </div><!-- /.box-footer-->
        </div><!-- /.box -->
    </div><!-- /.col -->
    @else
    @foreach ($registros as $registroData => $registroCount)
    <div class='col-md-6'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title text-blue">{{ $turma->curso->nome }} | {{ $turma->modulo->nome }} | {{ $turma->professor->nome }}</h3>
                <span class='pull-right text-green'>{{ $registroData }}</span>
            </div>
            <div class="box-body">                
                <h5>{{ $registroCount }} registros encontrados.</h5>
            </div><!-- /.box-body -->
            <div class="box-footer">
                <a href="{{url('chamadas/turma/' . $turma->id . '/' . str_replace('/','-', $registroData))}}" title="Ver detalhes" class="btn btn-success pull-right">Ver detalhes</a>
            </div><!-- /.box-footer-->
        </div><!-- /.box -->
    </div><!-- /.col -->
    @endforeach
    @endif
</div><!-- /.row -->
@endsection