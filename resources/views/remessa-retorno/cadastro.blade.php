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
                <h3 class="box-title">Emitir/Registrar</h3>
            </div><!-- /.box-header -->
            <form role="form" action="{{ url('/remessa-retorno/' . $remessaRetorno) }}" method="post">
                {!! csrf_field() !!}
                <div class="box-body">
                    <div class="form-group col-md-12">
                        @if($remessaRetorno == 'remessa' && count($boletos) > 0)                    
                        <label for="cadastro">Boletos ainda não processados</label>
                        @foreach($boletos as $boleto)
                        @if($boleto->status !== 'pago')
                        <div class="checkbox">
                            <label><input type="checkbox" name="boletos[]" value="{{ $boleto->id }}" >&nbsp;{{ $boleto->usuario_id !== NULL ? $boleto->usuario->nome . ' | ' . $boleto->referencia : $boleto->referencia }} | {{ $boleto->valor }} | {{ $boleto->status }}</label>
                        </div>
                        @endif
                        @endforeach
                        @elseif($remessaRetorno == 'remessa' && count($boletos) == 0)
                        <label for="cadastro">Não existem boletos para processar.</label>
                        <input class="form-control" name="boletos[]" type="hidden" value="">
                        @else
                        <label for="cadastro">Selecionar arquivo de retorno</label>
                        <input class="form-control" name="retorno_arquivo" type="file">
                        <br>
                        <p>
                            <strong class="text-red">Obs: Navegue até a pasta onde está o arquivo de retorno fornecido pelo banco, selecione e clique em "Abrir". 
                                Lembre-se: cada arquivo de retorno deve ser enviado apenas uma vez.</strong>
                        </p>
                        @endif
                    </div>
                </div>

                <div class="box-footer">
                    @if($remessaRetorno == 'remessa' && count($boletos) == 0)
                    <a href="{{url('/remessa-retorno')}}" class="btn btn-primary pull-right">Voltar</a>
                    @else
                    <button type="submit" class="btn btn-primary pull-right">Enviar</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div><!-- /.row -->
@endsection