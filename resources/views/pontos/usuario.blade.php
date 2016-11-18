@extends('layout/app')

@section('content')

<div class='row'>
    @if($data !== '')
    <div class='col-md-12'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title text-blue">{{ $usuario->nome }}</h3>
                <span class='pull-right text-green'>{{ $data }}</span>
            </div>
            <div class="box-body">                
                <table class="table table-striped tabData" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tipo</th>
                            <th>Hora</th>
                            <th>Data</th>
                            <th>Justificativa</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Tipo</th>
                            <th>Hora</th>
                            <th>Data</th>
                            <th>Justificativa</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($registros as $registro)
                        <tr>
                            <td>{{ $registro->id }}</td>
                            <td>{{ $registro->tipo }}</td>
                            <td>{{ $registro->hora }}</td>
                            <td>{{ $registro->data }}</td>
                            <td>{{ $registro->justificativa }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div><!-- /.box-body -->
            <div class="box-footer">
                <a href="" title="Adicionar um registro manualmente" class="btn btn-primary" data-toggle="modal" data-target="#modalPontos">Adicionar registro</a>
                <a href="{{url('pontos/usuario/' . $usuario->id )}}" title="Voltar" class="btn btn-success pull-right">Voltar</a>
            </div><!-- /.box-footer-->
        </div><!-- /.box -->
    </div><!-- /.col -->
    @else
    @foreach ($registros as $registroData => $registroCount)
    <div class='col-md-6'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title text-blue">{{ $usuario->nome }}</h3>
                <span class='pull-right text-green'>{{ $registroData }}</span>
            </div>
            <div class="box-body">                
                <h5>{{ $registroCount }} registros encontrados.</h5>
            </div><!-- /.box-body -->
            <div class="box-footer">
                <a href="" title="Adicionar um registro manualmente" class="btn btn-primary" data-toggle="modal" data-target="#modalPontos">Adicionar registro</a>
                <a href="{{url('pontos/usuario/' . $usuario->id . '/' . str_replace('/','-', $registroData))}}" title="Ver detalhes" class="btn btn-success pull-right">Ver detalhes</a>
            </div><!-- /.box-footer-->
        </div><!-- /.box -->
    </div><!-- /.col -->
    @endforeach
    @endif
</div><!-- /.row -->
@endsection

<div class="modal fade" id="modalPontos" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">×</span></button>
                <h3 class="box-title text-blue">Adicionar um registro manualmente</h3>
            </div>
            <form role="form" action="{{ url('/pontos/adicionar') }}" method="post">
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Hora</label>
                                <input class="form-control" value="" name="hora" type="text" placeholder="00:00">
                                <input type="hidden" name="usuario_id" value="{{ $usuario->id }}" />
                                <input type="hidden" name="ponto_id" value="" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Data</label>
                                <input class="form-control formDate" value="{{ (!empty($data) ? $data : '' )}}" name="data" type="text" >
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Tipo</label>
                                <select name="tipo" class="form-control">
                                    <option value="entrada">Entrada</option>
                                    <option value="saida">Saída</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-success pull-right" value="Registrar" />
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
