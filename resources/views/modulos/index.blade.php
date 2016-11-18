@extends('layout/app')

@section('content')

@if(Session::has('excluir'))
<div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-check"></i> Atenção!</h4>
    
     <form action="{{ url('usuarios/' . Session::get('usuario_id')) }}" method="POST">
         <div class="row">
         <div class="form-group col-md-10">
         {!! csrf_field() !!}
        {!! method_field('DELETE') !!}
        
        <label>
            {{ Session::get('excluir') }}
        </label>
        </div>

        <div class="form-group col-md-2">
            <a href='{{ url('usuarios') }}' class="btn btn-info">
                <i class="fa fa-close"></i> Não
            </a>
            &nbsp;
            <button type="submit" class="btn btn-danger">
                <i class="fa fa-trash"></i> Sim
            </button>
        </div>
         </div>
    </form>
</div>
@endif

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
                <h3 class="box-title">Alunos</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                @if(count($alunos) > 0)
                <table id="tabela_cadastro" class="table  table-striped" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Idade</th>
                            <th>Nascimento</th>
                            <!--th>Telefone</th-->
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Idade</th>
                        <th>Nascimento</th>
                        <!--th>Telefone</th-->
                        <th>Ação</th>
                    </tfoot>
                    <tbody>
                        @foreach($alunos as $aluno)
                        <tr>
                            <td>
                                {{ $aluno['id'] }}
                            </td>
                            <td>
                                <a href="usuarios/{{ $aluno['id'] }}" title="{{ $aluno['nome'] }} perfil ">{{ $aluno['nome'] }}</a>
                            </td>
                            <td>
                                {{ $aluno['idade'] }}
                            </td>
                            <td>
                                {{ $aluno['nascimento'] }}
                            </td>
                            <!--td>
                                {{ $aluno['celular'] }}
                            </td-->
                            <td>
                                <a href="{{ url('usuarios/' . $aluno['id'] . '/edit/') }}" title="Editar" ><i class="fa fa-edit"></i></a>
                                <a href="{{ url('usuarios/excluir/' . $aluno['id']) }}" title="Excluir" ><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <h5>
                    Nenhum aluno cadastrado.
                </h5>
                @endif
            </div><!-- /.box-body -->
            <div class="box-footer">

            </div><!-- /.box-footer-->
        </div><!-- /.box -->
    </div><!-- /.col -->
    <div class='col-md-6'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Professores / Funcionários</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                @if(count($professores) > 0)
                @foreach($professores as $professor)
                <h5>
                    {{ $professor['nome'] }}
                </h5>
                @endforeach
                @else
                <h5>
                    Nenhum professor cadastrado.
                </h5>
                @endif
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->

</div><!-- /.row -->
@endsection