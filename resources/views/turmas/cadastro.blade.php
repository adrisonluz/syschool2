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
    <div class='col-md-6'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Vinculos</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ url('/turmas') }}" method="post">
                {!! csrf_field() !!}
                <div class="box-body">
                    <div class="form-group">
                        <label>Professor</label>
                        @if(count($professores) > 0)
                        <select name="professor_id" class="form-control">
                            @foreach($professores as $professor)
                            <option value="{{ $professor->id }}">{{ $professor->nome }}</option>
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
                            <option value="{{ $curso->id }}">{{ $curso->nome }}</option>
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
                            <option value="{{ $modulo->id }}">{{ $modulo->nome }}</option>
                            @endforeach
                        </select>
                        @else
                        <p>Não há módulos cadastrados.</p>
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
                    @if(!empty($alunos))
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
                <h3 class="box-title">Horarios</h3>
            </div><!-- /.box-header -->
            <div class="box-body addHorario">
                <div class="form-group col-md-6 dia_semana">
                    <label for="cadastro">Dia da semana</label>
                    <select name="dia_semana[0]" class="form-control dia_semana">
                        <option value="">Selecione</option>
                        <option value="Mon">Segunda</option>
                        <option value="Tue">Terça</option>
                        <option value="Wed">Quarta</option>
                        <option value="Thu">Quinta</option>
                        <option value="Fri">Sexta</option>
                        <option value="Sat">Sábado</option>
                        <option value="Sun">Domingo</option>
                    </select>
                </div>

                <div class="form-group col-md-3 hora_inicio">
                    <label for="cadastro">Inicio</label>
                    <input class="form-control hora_inicio" name="hora_inicio[0]" placeholder="Ex: 14:00" type="text">
                </div>

                <div class="form-group col-md-3 hora_fim">
                    <label for="cadastro">Fim</label>
                    <input class="form-control hora_fim" name="hora_fim[0]" placeholder="Ex: 14:00" type="text">
                </div>

                <div class="form-group col-md-6 dia_semana">
                    <label for="cadastro">Dia da semana</label>
                    <select name="dia_semana[1]" class="form-control dia_semana">
                        <option value="">Selecione</option>
                        <option value="Mon">Segunda</option>
                        <option value="Tue">Terça</option>
                        <option value="Wed">Quarta</option>
                        <option value="Thu">Quinta</option>
                        <option value="Fri">Sexta</option>
                        <option value="Sat">Sábado</option>
                        <option value="Sun">Domingo</option>
                    </select>
                </div>

                <div class="form-group col-md-3 hora_inicio">
                    <label for="cadastro">Inicio</label>
                    <input class="form-control hora_inicio" name="hora_inicio[1]" placeholder="Ex: 14:00" type="text">
                </div>

                <div class="form-group col-md-3 hora_fim">
                    <label for="cadastro">Fim</label>
                    <input class="form-control hora_fim" name="hora_fim[1]" placeholder="Ex: 14:00" type="text">
                </div>

                <div class="form-group col-md-6 dia_semana">
                    <label for="cadastro">Dia da semana</label>
                    <select name="dia_semana[2]" class="form-control dia_semana">
                        <option value="">Selecione</option>
                        <option value="Mon">Segunda</option>
                        <option value="Tue">Terça</option>
                        <option value="Wed">Quarta</option>
                        <option value="Thu">Quinta</option>
                        <option value="Fri">Sexta</option>
                        <option value="Sat">Sábado</option>
                        <option value="Sun">Domingo</option>
                    </select>
                </div>

                <div class="form-group col-md-3 hora_inicio">
                    <label for="cadastro">Inicio</label>
                    <input class="form-control hora_inicio" name="hora_inicio[2]" placeholder="Ex: 14:00" type="text">
                </div>

                <div class="form-group col-md-3 hora_fim">
                    <label for="cadastro">Fim</label>
                    <input class="form-control hora_fim" name="hora_fim[2]" placeholder="Ex: 14:00" type="text">
                </div>

                <div class="form-group col-md-6 dia_semana">
                    <label for="cadastro">Dia da semana</label>
                    <select name="dia_semana[3]" class="form-control dia_semana">
                        <option value="">Selecione</option>
                        <option value="Mon">Segunda</option>
                        <option value="Tue">Terça</option>
                        <option value="Wed">Quarta</option>
                        <option value="Thu">Quinta</option>
                        <option value="Fri">Sexta</option>
                        <option value="Sat">Sábado</option>
                        <option value="Sun">Domingo</option>
                    </select>
                </div>

                <div class="form-group col-md-3 hora_inicio">
                    <label for="cadastro">Inicio</label>
                    <input class="form-control hora_inicio" name="hora_inicio[3]" placeholder="Ex: 14:00" type="text">
                </div>

                <div class="form-group col-md-3 hora_fim">
                    <label for="cadastro">Fim</label>
                    <input class="form-control hora_fim" name="hora_fim[3]" placeholder="Ex: 14:00" type="text">
                </div>

                <div class="form-group col-md-6 dia_semana">
                    <label for="cadastro">Dia da semana</label>
                    <select name="dia_semana[4]" class="form-control dia_semana">
                        <option value="">Selecione</option>
                        <option value="Mon">Segunda</option>
                        <option value="Tue">Terça</option>
                        <option value="Wed">Quarta</option>
                        <option value="Thu">Quinta</option>
                        <option value="Fri">Sexta</option>
                        <option value="Sat">Sábado</option>
                        <option value="Sun">Domingo</option>
                    </select>
                </div>

                <div class="form-group col-md-3 hora_inicio">
                    <label for="cadastro">Inicio</label>
                    <input class="form-control hora_inicio" name="hora_inicio[4]" placeholder="Ex: 14:00" type="text">
                </div>

                <div class="form-group col-md-3 hora_fim">
                    <label for="cadastro">Fim</label>
                    <input class="form-control hora_fim" name="hora_fim[4]" placeholder="Ex: 14:00" type="text">
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
                    <input class="form-control" name="vagas" placeholder="Total de vagas" type="text">
                </div>

                <div class="form-group">
                    <label for="cadastro">Aulas dadas</label>
                    <input class="form-control" name="aulas_dadas" placeholder="Se a turma já começou, informar" type="text">
                </div>

                <div class="form-group">
                    <label for="cadastro">Valor da anuidade</label>
                    <input class="form-control formDin" name="anuidade" placeholder="Valor">
                </div>

                <div class="box-footer">
                    <button type="button" class="btn btn-success verTurmas">Vincular alunos</button>
                    <button type="submit" class="btn btn-primary pull-right">Cadastrar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div><!-- /.row -->
@endsection
