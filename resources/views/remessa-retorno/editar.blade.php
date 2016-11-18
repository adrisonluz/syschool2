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

@if(empty($boleto))
{{ redirect('boletos') }}
@endif
<div class='row'>
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Informações</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <form role="form" action="{{ url('/boletos/' . $boleto->id ) }}" method="post">
                    {!! csrf_field() !!}
                    {!! method_field('PUT') !!}
                    <div class="form-group col-md-6">
                        <label for="cadastro">Data de emissão</label>
                        <input class="form-control formDate" name="" type="text" disabled="" value="{{ $boleto->data_emissao }}">
                        <input class="form-control formDate" name="data_emissao" type="hidden" value="{{ $boleto->data_emissao }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="cadastro">Data de vencimento</label>
                        <input class="form-control formDate" name="data_vencimento" placeholder="" type="text" value="{{ $boleto->data_vencimento }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="cadastro">Sequencial</label>
                        <input class="form-control" name="sequencial" placeholder="" type="text" value="{{ $boleto->sequencial }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="cadastro">Competência</label>
                        <input class="form-control" name="competencia" placeholder="" type="text" value="{{ $boleto->competencia }}">
                    </div>

                    <div class="form-group col-md-12">
                        <label>Referência</label>
                        <select name="referencia" class="form-control change">
                            <option value="change" {{ $boleto->referencia == 'mensalidade' ? 'selected' : ''}} >Mensalidade</option>
                            <option value="outros" {{ $boleto->referencia == 'outros' ? 'selected' : ''}} >Outros</option>
                        </select>
                    </div>

                    <div class="form-group col-md-12 change">
                        <label>Aluno</label>
                        @if(count($alunos) > 0)
                        <select name="usuario_id" class="form-control usuario_id">
                            @foreach($alunos as $aluno)
                            <option value="{{ $aluno->id }}" {{ $boleto->usuario_id == $aluno->id ? 'selected' : ''}}>{{ $aluno->nome . ($aluno->desconto !== '' ? ' | Desconto: ' . $aluno->desconto : '') }}</option>
                            @endforeach
                        </select>
                        @else
                        <p>Não há alunos cadastrados.</p>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label>Desconto</label>
                        <input class="form-control" name="desconto" placeholder="0,00" type="text" value="{{ $boleto->desconto }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Valor</label>
                        <input class="form-control" name="valor" placeholder="0,00" type="text" value="{{ $boleto->valor }}">
                    </div>


                    <div class="form-group col-md-12">
                        <label>Status</label>
                        <select name="status" class="form-control change">
                            <option value="aberto" {{ $boleto->status == 'aberto' ? 'selected' : ''}} >Aberto</option>
                            <option value="vencido" {{ $boleto->status == 'vencido' ? 'selected' : ''}} >Vencido</option>
                            <option value="pago" {{ $boleto->status == 'pago' ? 'selected' : ''}} >Pago</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Valor pagto</label>
                        <input class="form-control formDin" name="valor_pagto" placeholder="" type="text" value="{{ $boleto->valor_pagto == '' ? '' : $boleto->valor_pagto }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Data pagto</label>
                        <input class="form-control formDate" name="data_pagto" placeholder="" type="text" value="{{ $boleto->data_pagto == '' ? '' : $boleto->data_pagto }}">
                    </div>
            </div>

            <div class="box-footer">
                <!--a href="javascript:;" class="btn btn-success calculaMensalidade" data-toggle="modal" data-target="#modalMensalidade">Calcular mensalidade</a-->
                <button type="submit" class="btn btn-primary pull-right">Concluir</button>
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
