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
    <div class='col-md-12'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-body">
                <h4>Resultado da pesquisa por <strong class="text-uppercase text-maroon" id="searchKey">{{$chave}}</strong></h4>
                <div class="table-responsive">
                    @if(count($retorno) > 0)
                    <table class="table table-striped table-bordered table-hover col-md-12" id="tableSearch">
                        <thead class="">
                            <tr>
                                <td class="">Usuário</td>
                                <td class="">Campo</td>
                                <td class="">Resultado</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($retorno as $dados)
                            <tr>
                                <td><a href="usuarios/{{ $dados['id'] }}">{{ $dados['nome'] }}</a></td>
                                <td>{{ $dados['campo'] }}</td>
                                <td>{!! $dados['valor'] !!}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <h4>Sua busca não retornou nenhum resultado.</h4>
                    @endif
                </div>
            </div>
        </div><!-- /.box -->
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection
