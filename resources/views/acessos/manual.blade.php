@extends('layout/app')

@section('content')

@if(Session::has('success'))
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-check"></i> Sucesso!</h4>
    {{Session::get('success')}}
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
    <div class='col-md-6'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Chamada</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ url('/acessos/manual') }}" method="post">
                {!! csrf_field() !!}
                <div class="box-body">
                    <input class="form-control" name="tipo" type="hidden" value="chamada" />
                    <div class="form-group">
                        <label>Aluno</label>
                        @if(count($alunos) > 0)
                        <select name="aluno_id" class="form-control alunoAcessoManual">
                            <option value="">Selecione um aluno</option>
                            @foreach($alunos as $aluno)
                            <option value="{{ $aluno->id }}">{{ $aluno->nome }}</option>
                            @endforeach
                        </select>
                        @else
                        <p>Não há alunos cadastrados.</p>
                        @endif
                    </div>
                    
                    <div class="form-group">
                        <label>Turma</label>
                        <select name="turma_id" class="form-control turmaAcessoManual">
                            <option value="">Selecione um aluno</option>
                        </select>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="cadastro">Data</label>
                            <input class="form-control formDate" name="data" placeholder="Insira o dia" type="text">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="cadastro">Hora</label>
                            <input class="form-control formHora" name="hora" placeholder="Ex. 00:00" type="text">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Justificativa</label>
                        <textarea name="justif" class="form-control" rows="3" placeholder="Justificativa ..."></textarea>
                    </div>
                    
                    <p class="text-danger">* Todos os campos são obrigatórios.</p>
                </div>
                
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right">Validar</button>
                </div>
            </form>
        </div>
    </div><!-- /.col -->

    <div class="col-md-6">
        <div class="box box-primary">
        <form role="form" action="{{ url('/acessos/manual') }}" method="post">
                {!! csrf_field() !!}
            <div class="box-header with-border">
                <h3 class="box-title">Ponto</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <input class="form-control" name="tipo" type="hidden" value="ponto" />
                <div class="form-group">
                    <label>Professor / Funcionário</label>
                    @if(count($funcionarios) > 0)
                    <select name="func_id" class="form-control">
                        @foreach($funcionarios as $funcionario)
                        <option value="{{ $funcionario->id }}">{{ $funcionario->nome }}</option>
                        @endforeach
                    </select>
                    @else
                    <p>Não há funcionários cadastrados.</p>
                    @endif
                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="cadastro">Data</label>
                        <input class="form-control formDate" name="data" placeholder="Insira o dia" type="text">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="cadastro">Entrada</label>
                        <input class="form-control formHora" name="hora_entrada" placeholder="Ex. 00:00" type="text">
                    </div>
                    
                    <div class="form-group col-md-4">
                        <label for="cadastro">Saída</label>
                        <input class="form-control formHora" name="hora_saida" placeholder="Ex. 00:00" type="text">
                    </div>
                </div>

                <div class="form-group">
                    <label>Justificativa</label>
                    <textarea name="justif" class="form-control" rows="3" placeholder="Justificativa ..."></textarea>
                </div>
                
                <p class="text-danger">* Todos os campos são obrigatórios.</p>
            </div>
            
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Validar</button>
            </div>
        </form>
        </div>
    </div>
</div><!-- /.row -->
@endsection
