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
                @if($tipoBusca == 'data_cadastro')
                    @if (count($result) > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover col-md-12">
                            <thead class="">
                                <tr>
                                    @foreach($campos as $campo)
                                    @if ($campo !== 'id')
                                    <td>{{ $campo }}</td>
                                    @endif
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($result as $dados)
                                <tr>
                                    @foreach ($dados as $dadosKey => $dadosVal)
                                        @if($dadosKey == 'nascimento')
                                            <td>{{date('d/m/Y', strtotime($dadosVal))}}</td>
                                        @elseif($dadosKey !== 'id')
                                        <td>{{$dadosVal}}</td>
                                        @endif
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <h4>Sua busca não retornou nenhum resultado.</h4>
                    @endif
                    
                @elseif ($tipoBusca == 'turmas_relac')
                    @if (count($result) > 0)
                    <div class="table-responsive">
                        
                        @foreach($result as $dados)
                            <table class="table table-striped table-bordered table-hover col-md-12">
                                <thead class="">
                                    <tr>
                                        @foreach($campos as $campo)
                                        @if ($campo !== 'id')
                                        <td>{{ $campo }}</td>
                                        @endif
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @foreach ($dados as $dadosKey => $dadosVal)
                                            @if($dadosKey == 'nascimento')
                                                <td>{{date('d/m/Y', strtotime($dadosVal))}}</td>
                                            @elseif($dadosKey !== 'id' && $dadosKey !== 'relTurmas')
                                            <td>{{$dadosVal}}</td>
                                            @endif
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            @if (count($dados['relTurmas']) > 0)
                            <table class="table table-striped table-bordered table-hover col-md-12">
                                <thead class="">
                                    <tr>
                                        <td colspan="3" class="">Turmas relacionadas</td>
                                        <td>Nivel</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dados['relTurmas'] as $turma)
                                    <tr>
                                        <td>{{$turma['modulo']}}</td>
                                        <td>{{$turma['curso']}}</td>
                                        <td>{{$turma['professor']}}</td>
                                        <td>{{$turma['nivel']}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                            @else
                            <h5 class="text-red">* Nenhuma turma relacionada.</h5>
                            @endif
                            <br>
                        @endforeach
                    </div>
                    @else
                    <h4>Sua busca não retornou nenhum resultado.</h4>
                    <hr>
                    <a href="" class="btn btn-success">Voltar<a/>
                    @endif
                @endif
            </div>
            @if (count($result) > 0)
            <div class="box-footer">
                <form action="{{url('relatorios/imprimir')}}" method="post">
                    {!! csrf_field() !!}
                    <a href="" class="btn btn-success">Voltar<a/>                
                    <input type="hidden" value="" name="htmlTable" />
                    <input type="hidden" value="usuarios" name="tipo" />
                    <input type="submit" value="Imprimir" class="btn btn-primary pull-right" />
                </form>
            </div>
            @endif
        </div><!-- /.box -->
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection
