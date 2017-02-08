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
                    <form role="form" action="{{ url('/contratos') }}" method="post" id="formContrato">
                        {!! csrf_field() !!}
                    <div class="form-group col-md-12">
                        <label>Aluno</label>
                        @if(count($alunos) > 0)
                        <select name="usuario_id"  class="form-control desconto select2">
                            <option value="">Escolha um aluno</option>
                            @foreach($alunos as $aluno)
                            <option value="{{ $aluno->id }}">{{ $aluno->nome }}</option>
                            @endforeach
                        </select>
                        @else
                        <p>Não há alunos cadastrados.</p>
                        @endif
                    </div>
                        
                    <div class="desconto col-xs-12"></div>
                    
                    <div class="form-group col-md-12">
                        <label for="cadastro">Anuidade</label>
                        <input class="form-control formDin anuidade" name="" placeholder="00,00" type="text" disabled>
                        <input name="anuidade" type="hidden">
                    </div>    
                        
                    <div class="form-group col-md-6">
                        <label for="cadastro">Aplicar desconto</label>
                        <input class="form-control formDin" name="desconto" placeholder="00,00" type="text">
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
                        <label for="cadastro">Qtd parcelas</label>
                        <input class="form-control" name="parcelas" placeholder="Numero de parcelas" type="text">
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right" {{ (count($alunos) > 0) ? '' : 'disabled="disabled"' }}>Emitir</button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="col-md-6 tabela_anuidades" style="display:none;">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Anuidade Descrição</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <table class="table table-borded table-hover">
                    <thead class="thead-default">
                        <tr>
                            <td>Turma</td>
                            <td>Anuidade</td>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="active"><strong>TOTAL</strong></td>
                            <td class="total_anuidade"></td>
                        </tr>                        
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div><!-- /.row -->
@endsection
