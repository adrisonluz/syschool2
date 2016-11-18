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

@if(empty($turma))
{{ redirect('turmas') }}
@endif
<div class='row'>
    <div class='col-md-6'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Vinculos</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ url('/turmas/' . $turma->id) }}" method="post">
                {!! csrf_field() !!}
                {!! method_field('PUT') !!}
                <div class="box-body">
                    <div class="form-group">
                        <label>Professor</label>
                        @if(count($professores) > 0)
                        <select name="professor_id" class="form-control">
                            @foreach($professores as $professor)
                            <option value="{{ $professor->id }}" {{ $professor->id == $turma->professor_id ? 'selected="selected"' : '' }} >{{ $professor->nome }}</option>
                            @endforeach
                        </select>
                        @else
                        <p>Não há professores cadastrados.</p>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Curso</label>
                        @if(count($cursos) > 0)
                        <select name="curso_id" class="form-control">
                            @foreach($cursos as $curso)
                            <option value="{{ $curso->id }}" {{ $curso->id == $turma->curso_id ? 'selected="selected"' : '' }} >{{ $curso->nome }}</option>
                            @endforeach
                        </select>
                        @else
                        <p>Não há cursos cadastrados.</p>
                        @endif
                    </div>
                </div>
        </div>

        <div class="box box-primary verTurmas">
            <div class="box-header with-border">
                <h3 class="box-title">Vincular alunos</h3>
            </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group verTurmas">
                        <label>Vincular alunos</label>
                        @if(count($alunos) > 0)
                        <select name="alunos[]" multiple class="form-control">
                            @foreach($alunos as $aluno)
                            <option value="{{ $aluno->id }}">{{ $aluno->nome }}</option>
                            @endforeach
                        </select>
                        @else
                        <p>Não há alunos cadastrados.</p>
                        @endif
                    </div>
                </div>
        </div>
    </div><!-- /.col -->

    <div class="col-md-6">
        <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Informações</h3>
                </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group">
                        <label for="cadastro">Dias na semana</label>
                        <input class="form-control" name="dias" placeholder="Ex: Seg e Qua" type="text" value="{{ $turma->dias }}">
                    </div>

                    <div class="form-group">
                        <label for="cadastro">Horário</label>
                        <input class="form-control" name="horario" placeholder="Ex: 14:00 às 15:00" type="text" value="{{ $turma->horario }}">
                    </div>

                    <div class="form-group">
                        <label for="cadastro">Vagas</label>
                        <input class="form-control" name="vagas" placeholder="Total de vagas" type="text" value="{{ $turma->vagas }}">
                    </div>

                    <div class="form-group">
                        <label for="cadastro">Aulas dadas</label>
                        <input class="form-control" name="aulas_dadas" placeholder="Se a turma já começou, informar" type="text" value="{{ $turma->aulas_dadas }}">
                    </div>

                    <div class="form-group">
                        <label for="cadastro">Valor da mensalidade</label>
                        <input class="form-control formDin" name="valor_mensalidade" placeholder="Valor" value="{{ $turma->valor_mensalidade }}">
                    </div>

                    <div class="box-footer">
                        <button type="button" class="btn btn-success verTurmas">Vincular alunos</button>
                        <button type="submit" class="btn btn-primary pull-right">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.col -->

</div><!-- /.row -->
@endsection
