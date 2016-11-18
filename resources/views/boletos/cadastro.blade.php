@extends('layout/app')

@section('content')

@if(Session::has('error'))
<div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-check"></i> Atenção!</h4>

    <form action="{{ url('boletos/' . Session::get('boleto_id')) }}" method="POST">
        <div class="row">
            <div class="form-group col-md-10">
                {!! csrf_field() !!}

                <label>
                    {{ Session::get('error') }}
                </label>
            </div>

            <div class="form-group col-md-2">
                <a href='{{ url('boletos') }}' class="btn btn-info">
                    <i class="fa fa-close"></i> Não
                </a>
                &nbsp;
                <a href="{{ url('boletos/' . Session::get('boleto_id') . '/edit') }}" class="btn btn-danger">
                    <i class="fa fa-trash"></i> Sim
                </a>
            </div>
        </div>
    </form>
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
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Informações</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <form role="form" action="{{ url('/boletos') }}" method="post">
                    {!! csrf_field() !!}

                    <div class="form-group col-md-6">
                        <label for="cadastro">Data de emissão</label>
                        <input class="form-control formDate" name="data_emissao" type="text" value="{{ date('d/m/Y') }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="cadastro">Data de vencimento</label>
                        <input class="form-control formDate" name="data_vencimento" placeholder="" type="text" value="{{ date('d/m/Y',strtotime(date('Y-m-d').'+5 day')) }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="cadastro">Sequencial</label>
                        <input class="form-control" name="sequencial" placeholder="" type="text" value="{{ date('dmyHi') }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="cadastro">Competência</label>
                        <input class="form-control" name="competencia" placeholder="" type="text" value="{{ date('m/Y') }}">
                    </div>

                    <div class="form-group col-md-12">
                        <label>Referência</label>
                        <select name="referencia" class="form-control change">
                            <option value="outros">Outros</option>
                            <option value="change">Mensalidade</option>
                        </select>
                    </div>

                    <div class="form-group col-md-12 change">
                        <label>Aluno</label>
                        @if(count($alunos) > 0)
                        <select name="usuario_id" class="form-control usuario_id">
                            @foreach($alunos as $aluno)
                            <option value="{{ $aluno->id }}">{{ $aluno->nome . ($aluno->desconto !== '' ? ' | Desconto: ' . $aluno->desconto : '') }}</option>
                            @endforeach
                        </select>
                        @else
                        <p>Não há alunos cadastrados.</p>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label>Desconto</label>
                        <input class="form-control" name="desconto" placeholder="0,00" type="text" value="0,00">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Valor</label>
                        <input class="form-control" name="valor" placeholder="0,00" type="text">
                    </div>
            </div>

            <div class="box-footer">
                <a href="javascript:;" class="btn btn-success calculaMensalidade" data-toggle="modal" data-target="#modalMensalidade">Calcular mensalidade</a>
                <button type="submit" class="btn btn-primary pull-right">Emitir</button>
            </div>
            </form>
        </div>
    </div>
</div><!-- /.row -->
@endsection

<div class="modal fade" id="modalMensalidade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">×</span></button>
                <h3 class="box-title">Calcular valor da mensalidade</h3>
            </div>
            <div class="modal-body">
                <table class="table table-striped" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Turma</th>
                            <th>Mensalidade</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
