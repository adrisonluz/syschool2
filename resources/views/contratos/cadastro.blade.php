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
    <div class="col-md-6">
        <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Informações</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <form role="form" action="{{ url('/contratos') }}" method="post">
                        {!! csrf_field() !!}
                    <div class="form-group">
                        <label>Aluno</label>
                        @if(count($alunos) > 0)
                        <select name="usuario_id" class="form-control">
                            @foreach($alunos as $aluno)
                            <option value="{{ $aluno->id }}">{{ $aluno->nome }}</option>
                            @endforeach
                        </select>
                        @else
                        <p>Não há alunos cadastrados.</p>
                        @endif
                    </div>
                        
                    <div class="form-group col-md-6">
                        <label for="cadastro">Valor da matricula</label>
                        <input class="form-control formDin" name="valor_matricula" placeholder="00,00" type="text">
                    </div>
                        
                    <div class="form-group col-md-6">
                            <label for="cadastro">Data</label>
                            <input class="form-control formDate" name="data" placeholder="" type="text" value="{{date('d/m/Y')}}">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="cadastro">Qtd meses</label>
                        <input class="form-control" name="meses" placeholder="Duração do contrato" type="text">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="cadastro">Qtd mensalidades</label>
                        <input class="form-control" name="mensalidades" placeholder="Numero de mensalidades" type="text">
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right" {{ (count($alunos) > 0) ? '' : 'disabled="disabled"' }}>Emitir</button>
                </div>
            </form>
        </div>
    </div>
</div><!-- /.row -->
@endsection
