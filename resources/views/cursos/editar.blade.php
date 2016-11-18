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

@if(empty($curso))
{{redirect('cursos')}}
@endif
<div class='row'>
    <div class='col-md-6'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Dados do curso</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ url('/cursos/' . $curso->id ) }}" method="post">
                {!! csrf_field() !!}
                {!! method_field('PUT') !!}
                <div class="box-body">
                    <div class="form-group">
                        <label for="cadastro">Nome do curso</label>
                        <input class="form-control" name="nome" placeholder="Digite um nome" type="text" value="{{ $curso->nome }}">
                    </div>

                    <div class="form-group">
                        <label for="cadastro">Quantidade de aulas</label>
                        <input class="form-control" name="qtd_aulas" placeholder="Quantas aulas tem o curso" type="text" value="{{ $curso->qtd_aulas }}">
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right">Salvar</button>
                </div>
            </form>
        </div>
    </div><!-- /.col -->

</div><!-- /.row -->
@endsection
