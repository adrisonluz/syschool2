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

                    <div class="form-group">
                        <label>Módulo</label>
                        @if(count($modulos) > 0)
                        <select name="modulo_id" class="form-control">
                            @foreach($modulos as $modulo)
                            <option value="{{ $modulo->id }}" {{ $modulo->id == $turma->modulo_id ? 'selected="selected"' : '' }} >{{ $modulo->nome }}</option>
                            @endforeach
                        </select>
                        @else
                        <p>Não há modulos cadastrados.</p>
                        @endif
                    </div>
                </div>
        </div>

        <div class="box box-primary verTurmas">
            <div class="box-header with-border">
                <h3 class="box-title">Vincular alunos <span class="text-yellow">{{ ($turmaCheia) ? "- turma cheia -" : ''}}</span></h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="form-group verTurmas">
                    <label>Vincular alunos</label>
                    @if(count($alunos) > 0)
                    <select name="alunos[]" multiple class="form-control">
                        @foreach($alunos as $aluno)
                        <option value="{{ $aluno->id }}" {{ in_array($aluno->id, $matriculas) ? 'selected' : '' }}  >{{ $aluno->nome }}</option>
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
                <h3 class="box-title">Horarios</h3>
            </div><!-- /.box-header -->

            <div class="box-body addHorario">
                <div class="form-group col-md-6 dia_semana {{ (array_key_exists(0, $horarios) ? 'active' : '') }}">
                    <label for="cadastro">Dia da semana</label>
                    <select name="dia_semana[0]" class="form-control dia_semana">
                        <option value="">Selecione</option>
                        <option value="Mon" {{ (array_key_exists(0, $horarios) && $horarios[0]['dia_semana'] == 'Mon' ? 'selected' : '') }}>Segunda</option>
                        <option value="Tue" {{ (array_key_exists(0, $horarios) && $horarios[0]['dia_semana'] == 'Tue' ? 'selected' : '') }}>Terça</option>
                        <option value="Wed" {{ (array_key_exists(0, $horarios) && $horarios[0]['dia_semana'] == 'Wed' ? 'selected' : '') }}>Quarta</option>
                        <option value="Thu" {{ (array_key_exists(0, $horarios) && $horarios[0]['dia_semana'] == 'Thu' ? 'selected' : '') }}>Quinta</option>
                        <option value="Fri" {{ (array_key_exists(0, $horarios) && $horarios[0]['dia_semana'] == 'Fri' ? 'selected' : '') }}>Sexta</option>
                        <option value="Sat" {{ (array_key_exists(0, $horarios) && $horarios[0]['dia_semana'] == 'Sat' ? 'selected' : '') }}>Sábado</option>
                        <option value="Sun" {{ (array_key_exists(0, $horarios) && $horarios[0]['dia_semana'] == 'Sun' ? 'selected' : '') }}>Domingo</option>
                    </select>
                </div>

                <div class="form-group col-md-3 hora_inicio {{ (array_key_exists(0, $horarios) ? 'active' : '') }}">
                    <label for="cadastro">Inicio</label>
                    <input class="form-control hora_inicio" name="hora_inicio[0]" placeholder="Ex: 14:00" type="text" value="{{ (array_key_exists(0, $horarios) ? $horarios[0]['hora_inicio'] : '') }}">
                </div>

                <div class="form-group col-md-3 hora_fim {{ (array_key_exists(0, $horarios) ? 'active' : '') }}">
                    <label for="cadastro">Fim</label>
                    <input class="form-control hora_fim" name="hora_fim[0]" placeholder="Ex: 14:00" type="text" value="{{ (array_key_exists(0, $horarios) ? $horarios[0]['hora_fim'] : '') }}">
                </div>

                <div class="form-group col-md-6 dia_semana {{ (array_key_exists(1, $horarios) ? 'active' : '') }}">
                    <label for="cadastro">Dia da semana</label>
                    <select name="dia_semana[1]" class="form-control dia_semana">
                        <option value="">Selecione</option>
                        <option value="Mon" {{ (array_key_exists(1, $horarios) && $horarios[1]['dia_semana'] == 'Mon' ? 'selected' : '') }}>Segunda</option>
                        <option value="Tue" {{ (array_key_exists(1, $horarios) && $horarios[1]['dia_semana'] == 'Tue' ? 'selected' : '') }}>Terça</option>
                        <option value="Wed" {{ (array_key_exists(1, $horarios) && $horarios[1]['dia_semana'] == 'Wed' ? 'selected' : '') }}>Quarta</option>
                        <option value="Thu" {{ (array_key_exists(1, $horarios) && $horarios[1]['dia_semana'] == 'Thu' ? 'selected' : '') }}>Quinta</option>
                        <option value="Fri" {{ (array_key_exists(1, $horarios) && $horarios[1]['dia_semana'] == 'Fri' ? 'selected' : '') }}>Sexta</option>
                        <option value="Sat" {{ (array_key_exists(1, $horarios) && $horarios[1]['dia_semana'] == 'Sat' ? 'selected' : '') }}>Sábado</option>
                        <option value="Sun" {{ (array_key_exists(1, $horarios) && $horarios[1]['dia_semana'] == 'Sun' ? 'selected' : '') }}>Domingo</option>
                    </select>
                </div>

                <div class="form-group col-md-3 hora_inicio {{ (array_key_exists(1, $horarios) ? 'active' : '') }}">
                    <label for="cadastro">Inicio</label>
                    <input class="form-control hora_inicio" name="hora_inicio[1]" placeholder="Ex: 14:00" type="text"  value="{{ (array_key_exists(1, $horarios) ? $horarios[1]['hora_inicio'] : '') }}">
                </div>

                <div class="form-group col-md-3 hora_fim {{ (array_key_exists(1, $horarios) ? 'active' : '') }}">
                    <label for="cadastro">Fim</label>
                    <input class="form-control hora_fim" name="hora_fim[1]" placeholder="Ex: 14:00" type="text" value="{{ (array_key_exists(1, $horarios) ? $horarios[1]['hora_fim'] : '') }}">
                </div>

                <div class="form-group col-md-6 dia_semana {{ (array_key_exists(2, $horarios) ? 'active' : '') }}">
                    <label for="cadastro">Dia da semana</label>
                    <select name="dia_semana[2]" class="form-control dia_semana">
                        <option value="">Selecione</option>
                        <option value="Mon" {{ (array_key_exists(2, $horarios) && $horarios[2]['dia_semana'] == 'Mon' ? 'selected' : '') }}>Segunda</option>
                        <option value="Tue" {{ (array_key_exists(2, $horarios) && $horarios[2]['dia_semana'] == 'Tue' ? 'selected' : '') }}>Terça</option>
                        <option value="Wed" {{ (array_key_exists(2, $horarios) && $horarios[2]['dia_semana'] == 'Wed' ? 'selected' : '') }}>Quarta</option>
                        <option value="Thu" {{ (array_key_exists(2, $horarios) && $horarios[2]['dia_semana'] == 'Thu' ? 'selected' : '') }}>Quinta</option>
                        <option value="Fri" {{ (array_key_exists(2, $horarios) && $horarios[2]['dia_semana'] == 'Fri' ? 'selected' : '') }}>Sexta</option>
                        <option value="Sat" {{ (array_key_exists(2, $horarios) && $horarios[2]['dia_semana'] == 'Sat' ? 'selected' : '') }}>Sábado</option>
                        <option value="Sun" {{ (array_key_exists(2, $horarios) && $horarios[2]['dia_semana'] == 'Sun' ? 'selected' : '') }}>Domingo</option>
                    </select>
                </div>

                <div class="form-group col-md-3 hora_inicio {{ (array_key_exists(2, $horarios) ? 'active' : '') }}">
                    <label for="cadastro">Inicio</label>
                    <input class="form-control hora_inicio" name="hora_inicio[2]" placeholder="Ex: 14:00" type="text"  value="{{ (array_key_exists(2, $horarios) ? $horarios[2]['hora_inicio'] : '') }}">
                </div>

                <div class="form-group col-md-3 hora_fim {{ (array_key_exists(2, $horarios) ? 'active' : '') }}">
                    <label for="cadastro">Fim</label>
                    <input class="form-control hora_fim" name="hora_fim[2]" placeholder="Ex: 14:00" type="text" value="{{ (array_key_exists(2, $horarios) ? $horarios[2]['hora_fim'] : '') }}">
                </div>

                <div class="form-group col-md-6 dia_semana {{ (array_key_exists(3, $horarios) ? 'active' : '') }}">
                    <label for="cadastro">Dia da semana</label>
                    <select name="dia_semana[3]" class="form-control dia_semana">
                        <option value="">Selecione</option>
                        <option value="Mon" {{ (array_key_exists(3, $horarios) && $horarios[3]['dia_semana'] == 'Mon' ? 'selected' : '') }}>Segunda</option>
                        <option value="Tue" {{ (array_key_exists(3, $horarios) && $horarios[3]['dia_semana'] == 'Tue' ? 'selected' : '') }}>Terça</option>
                        <option value="Wed" {{ (array_key_exists(3, $horarios) && $horarios[3]['dia_semana'] == 'Wed' ? 'selected' : '') }}>Quarta</option>
                        <option value="Thu" {{ (array_key_exists(3, $horarios) && $horarios[3]['dia_semana'] == 'Thu' ? 'selected' : '') }}>Quinta</option>
                        <option value="Fri" {{ (array_key_exists(3, $horarios) && $horarios[3]['dia_semana'] == 'Fri' ? 'selected' : '') }}>Sexta</option>
                        <option value="Sat" {{ (array_key_exists(3, $horarios) && $horarios[3]['dia_semana'] == 'Sat' ? 'selected' : '') }}>Sábado</option>
                        <option value="Sun" {{ (array_key_exists(3, $horarios) && $horarios[3]['dia_semana'] == 'Sun' ? 'selected' : '') }}>Domingo</option>
                    </select>
                </div>

                <div class="form-group col-md-3 hora_inicio {{ (array_key_exists(3, $horarios) ? 'active' : '') }}">
                    <label for="cadastro">Inicio</label>
                    <input class="form-control hora_inicio" name="hora_inicio[3]" placeholder="Ex: 14:00" type="text"  value="{{ (array_key_exists(3, $horarios) ? $horarios[3]['hora_inicio'] : '') }}">
                </div>

                <div class="form-group col-md-3 hora_fim {{ (array_key_exists(3, $horarios) ? 'active' : '') }}">
                    <label for="cadastro">Fim</label>
                    <input class="form-control hora_fim" name="hora_fim[3]" placeholder="Ex: 14:00" type="text" value="{{ (array_key_exists(3, $horarios) ? $horarios[3]['hora_fim'] : '') }}">
                </div>

                <div class="form-group col-md-6 dia_semana {{ (array_key_exists(4, $horarios) ? 'active' : '') }}">
                    <label for="cadastro">Dia da semana</label>
                    <select name="dia_semana[4]" class="form-control dia_semana">
                        <option value="">Selecione</option>
                        <option value="Mon" {{ (array_key_exists(4, $horarios) && $horarios[4]['dia_semana'] == 'Mon' ? 'selected' : '') }}>Segunda</option>
                        <option value="Tue" {{ (array_key_exists(4, $horarios) && $horarios[4]['dia_semana'] == 'Tue' ? 'selected' : '') }}>Terça</option>
                        <option value="Wed" {{ (array_key_exists(4, $horarios) && $horarios[4]['dia_semana'] == 'Wed' ? 'selected' : '') }}>Quarta</option>
                        <option value="Thu" {{ (array_key_exists(4, $horarios) && $horarios[4]['dia_semana'] == 'Thu' ? 'selected' : '') }}>Quinta</option>
                        <option value="Fri" {{ (array_key_exists(4, $horarios) && $horarios[4]['dia_semana'] == 'Fri' ? 'selected' : '') }}>Sexta</option>
                        <option value="Sat" {{ (array_key_exists(4, $horarios) && $horarios[4]['dia_semana'] == 'Sat' ? 'selected' : '') }}>Sábado</option>
                        <option value="Sun" {{ (array_key_exists(4, $horarios) && $horarios[4]['dia_semana'] == 'Sun' ? 'selected' : '') }}>Domingo</option>
                    </select>
                </div>

                <div class="form-group col-md-3 hora_inicio {{ (array_key_exists(4, $horarios) ? 'active' : '') }}">
                    <label for="cadastro">Inicio</label>
                    <input class="form-control hora_inicio" name="hora_inicio[4]" placeholder="Ex: 14:00" type="text"  value="{{ (array_key_exists(4, $horarios) ? $horarios[4]['hora_inicio'] : '') }}">
                </div>

                <div class="form-group col-md-3 hora_fim {{ (array_key_exists(4, $horarios) ? 'active' : '') }}">
                    <label for="cadastro">Fim</label>
                    <input class="form-control hora_fim" name="hora_fim[4]" placeholder="Ex: 14:00" type="text" value="{{ (array_key_exists(4, $horarios) ? $horarios[4]['hora_fim'] : '') }}">
                </div>
            </div>

            <div class="box-footer">
                <button type="button" class="btn btn-success pull-right addHorario">Adicionar horário</button>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Informações</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="form-group">
                    <label for="cadastro">Vagas</label>
                    <input class="form-control" name="vagas" placeholder="Total de vagas" type="text" value="{{ $turma->vagas }}">
                </div>

                <div class="form-group">
                    <label for="cadastro">Aulas dadas</label>
                    <input class="form-control" name="aulas_dadas" placeholder="Se a turma já começou, informar" type="text" value="{{ $turma->aulas_dadas }}">
                </div>

                <div class="form-group">
                    <label for="cadastro">Valor da anuidade</label>
                    <input class="form-control formDin" name="anuidade" placeholder="Valor" value="{{ $turma->mensalidade }}">
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
