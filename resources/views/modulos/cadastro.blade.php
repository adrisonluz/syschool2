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
                <h3 class="box-title">Novo curso</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ url('/modulos') }}" method="post">
                {!! csrf_field() !!}
                <div class="box-body">
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
                        <label for="cadastro">Nome do módulo</label>
                        <input class="form-control" name="nome" placeholder="Digite um nome" type="text">
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</div><!-- /.row -->
@endsection
