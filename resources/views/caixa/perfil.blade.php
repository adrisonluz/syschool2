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
<div class="row">
    <div class="col-md-12">
      <!-- Box -->
          <div class="box box-primary">
              <div class="box-header with-border">
                  <h3 class="box-title">{{ $caixa->hora_fechamento !== '' ? 'Caixa ' . $caixa->data : 'Caixa Hoje' }}</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
              <form role="form" action="{{ url('/caixa') }}" method="post">
                  {!! csrf_field() !!}
                  <div class="box-body">
                        <input type="hidden" name="caixa_id" value="{{ !empty($caixaMae) ? $caixaMae->id : '' }}" />
                      <div class="form-group col-md-1">
                        <label>Aberto</label>
                        <input class="form-control" name="hora_abertura" disabled="disabled" value="{{ $caixa->hora_abertura }}" type="text">
                      </div>
                      <div class="form-group col-md-1">
                        <label>Fechado</label>
                        <input class="form-control" name="hora_fechamento" disabled="disabled" value="{{ ($caixa->hora_fechamento == null ? 'Em aberto' : $caixa->hora_fechamento) }}" type="text">
                      </div>
                      <div class="form-group col-md-2">
                        <label>Saldo inicial</label>
                        <input class="form-control" name="saldo_inicial" disabled="disabled" value="{{ $caixa->saldo_inicial }}" type="text">
                      </div>
                      <div class="form-group col-md-2">
                        <label>Total entradas</label>
                        <input class="form-control" name="total_entradas" disabled="disabled" value="{{ ($caixa->total_entradas == null ? 'Em aberto' : $caixa->total_entradas) }}" type="text">
                      </div>
                      <div class="form-group col-md-2">
                        <label>Total saídas</label>
                        <input class="form-control" name="total_saidas" disabled="disabled" value="{{ ($caixa->total_saidas == null ? 'Em aberto' : $caixa->total_saidas) }}" type="text">
                      </div>
                      <div class="form-group col-md-2">
                        <label>Saldo parcial</label>
                        <input class="form-control" name="saldo_parcial" disabled="disabled" value="{{ $saldo }}" type="text">
                      </div>
                      <div class="form-group col-md-2">
                        <label>Saldo final</label>
                        <input class="form-control" name="saldo_final" disabled="disabled" value="{{ ($caixa->saldo_final == null ? 'Em aberto' : $caixa->saldo_final) }}" type="text">
                      </div>
                  </div>
              </form>
          </div>
      </div>

    <div class='col-md-6'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Entradas neste caixa</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                @if(count($entradas) > 0)
                <table class="table  table-striped" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Hora</th>
                            <th>Valor</th>
                            <th>Descrição</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Hora</th>
                            <th>Valor</th>
                            <th>Descrição</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($entradas as $entrada)
                        <tr>
                            <td>{{ $entrada->hora }}</td>
                            <td>{{ $entrada->valor }}</td>
                            <td>{{ $entrada->desc }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p>Nenhum registro encontrado.</p>
                @endif
            </div>
        </div>
    </div><!-- /.col -->

    <div class='col-md-6'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Saidas neste caixa</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                @if(count($saidas) > 0)
                <table class="table  table-striped" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Hora</th>
                            <th>Valor</th>
                            <th>Descrição</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Hora</th>
                            <th>Valor</th>
                            <th>Descrição</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($saidas as $saida)
                        <tr>
                            <td>{{ $saida->hora }}</td>
                            <td>{{ $saida->valor }}</td>
                            <td>{{ $saida->desc }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p>Nenhum registro encontrado.</p>
                @endif
            </div>
        </div>
    </div><!-- /.col -->

    @if($caixa->saldo_final == null)
    <div class="col-md-6 pull-right">
        <div class="box box-primary">
            <div class="box-header with-border">
              <form role="form" action="{{ url('/caixa/fechar/' . $caixa->id) }}" method="post">
                  {!! csrf_field() !!}
                <a href="javascript:;" class="btn btn-primary btnEntrada" data-toggle="modal" data-target="#modalEntrada">Nova entrada</a>
                <a href="javascript:;" class="btn btn-success btnSaida" data-toggle="modal" data-target="#modalSaida">Nova saida</a>
                <button type="submit" class="btn btn-danger pull-right">Fechar caixa</button>
                
              </form>
            </div><!-- /.box-header -->
        </div>
    </div>
    @endif
    
  @if(count($caixasRelacionados) > 1)
  <div class="row">
      <div class="col-md-12">
          <div class="box box-primary">
              <div class="box-header with-border">
                  <h3 class="box-title">Caixas relacionados</h3>
                  <div class="box-tools pull-right">
                      <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                      <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                  </div>
              </div><!-- /.box-header -->
              <!-- form start -->
              <form role="form" action="{{ url('/caixa/fechar') }}" method="post">
                  {!! csrf_field() !!}
                  <div class="box-body">
                      @foreach($caixasRelacionados as $caixaRelacionado)
                      @if($caixaRelacionado->id == $caixa->id)

                      @else
                      <div class="form-group col-md-2">
                        <label>Hora da abertura</label>
                        <input class="form-control" name="hora_abertura" disabled="disabled" value="{{ $caixaRelacionado->hora_abertura }}" type="text">
                      </div>
                      <div class="form-group col-md-2">
                        <label>Hora do fechamento</label>
                        <input class="form-control" name="hora_fechamento" disabled="disabled" value="{{ $caixaRelacionado->hora_fechamento }}" type="text">
                      </div>
                      <div class="form-group col-md-2">
                        <label>Saldo inicial</label>
                        <input class="form-control" name="saldo_inicial" disabled="disabled" value="{{ $caixaRelacionado->saldo_inicial }}" type="text">
                      </div>
                      <div class="form-group col-md-2">
                        <label>Total entradas</label>
                        <input class="form-control" name="total_entradas" disabled="disabled" value="{{ $caixaRelacionado->total_entradas }}" type="text">
                      </div>
                      <div class="form-group col-md-2">
                        <label>Total saídas</label>
                        <input class="form-control" name="total_saidas" disabled="disabled" value="{{ $caixaRelacionado->total_saidas }}" type="text">
                      </div>
                      <div class="form-group col-md-2">
                        <label>Saldo final</label>
                        <input class="form-control" name="saldo_final" disabled="disabled" value="{{ $caixaRelacionado->saldo_final }}" type="text">
                      </div>
                      @endif
                      @endforeach
                  </div>
              </form>
          </div>
      </div>
  </div>
  @endif
@endsection

<div class="modal fade modalEntrada" id="modalEntrada" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">×</span></button>
        <h3 class="box-title">Nova entrada</h3>
      </div>
      <form role="form" action="{{ url('/movimentacao/entrada') }}" method="post">
      <div class="modal-body">
          {!! csrf_field() !!}
            <div class="form-group">
              <label>Valor</label>
              <input class="form-control formDin" value="" name="valor" type="text">
              <input type="hidden" name="caixa_id" value="{{ $caixa->id }}" />
            </div>

            <div class="form-group">
                <label>Tipo de movimentação</label>
                <select name="desc_select" class="form-control change">
                    <option value="change">Outros</option>
                </select>
            </div>

            <div class="form-group change">
              <label>Descrição</label>
              <textarea name="desc_textarea" class="form-control" placeholder="Descreva esta entrada."></textarea>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary">Lançar</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade modalSaida" id="modalSaida" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">×</span></button>
        <h3 class="box-title">Nova Saida</h3>
      </div>
      <form role="form" action="{{ url('/movimentacao/saida') }}" method="post">
      <div class="modal-body">
            {!! csrf_field() !!}
            <div class="form-group">
              <label>Valor</label>
              <input class="form-control formDin" value="" name="valor" type="text">
              <input type="hidden" name="caixa_id" value="{{ $caixa->id }}" />
            </div>

            <div class="form-group">
                <label>Tipo de movimentação</label>
                <select name="desc_select" class="form-control change">
                    <option value="outros">Outros</option>
                    <option value="mensalidade">Mensalidade</option>
                </select>
            </div>
            
            <div class="form-group mensalidade">
                <label>Aluno</label>
                @if(count($alunos) > 0)
                <select name="usuario_id" class="form-control usuario_id">
                    @foreach($alunos as $aluno)
                    <option value="{{ $aluno->id }}">{{ $aluno->nome . ' | Desconto: ' . $aluno->desconto }}</option>
                    @endforeach
                </select>
                @else
                <p>Não há alunos cadastrados.</p>
                @endif
            </div>

            <div class="form-group change">
              <label>Descrição</label>
              <textarea name="desc_textarea" class="form-control" placeholder="Descreva esta saida."></textarea>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary">Lançar</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
