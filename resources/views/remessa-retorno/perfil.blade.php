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
    <div class="col-md-3">

      <!-- Profile Image -->
      <div class="box box-primary">
        <div class="box-body box-profile">
          <img class="profile-user-img img-responsive img-circle" src="{{ asset('assets/' . ($usuario->foto == '' ? 'img/default.png' : $usuario->foto)) }}" alt="User profile picture">
          <h3 class="profile-username text-center">{{ $usuario->nome }}</h3>
          <p class="text-muted text-center">{{ $usuario->nivel }}</p>

          <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
              <b>Nascimento</b> <a class="pull-right">{{ $usuario->nascimento }}</a>
            </li>
            <li class="list-group-item">
              <b>Idade</b> <a class="pull-right">{{ $usuario->idade }}</a>
            </li>
            <li class="list-group-item">
              <b>Matrícula</b> <a class="pull-right">{{ $usuario->id }}</a>
            </li>
          </ul>

          <a href="{{ url('usuarios/' . $usuario->id . '/edit') }}" class="btn btn-primary btn-block"><b>Editar</b></a>
        </div><!-- /.box-body -->
      </div><!-- /.box -->

      <!-- About Me Box -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Emergência</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <strong>Em caso de emergência ligar para:</strong>
          <p class="text-muted">{{ $usuario->emerg_nome }} - {{ $usuario->emerg_telefone }}</p>
          <hr>
          <strong>Possui algum problema de saúde?</strong>
          <p class="text-muted">{{ $usuario->problema_saude }}</p>
          <hr>
          <strong>Possui alguma alergia?</strong>
          <p class="text-muted">{{ $usuario->alergia }}</p>
          <hr>
          <strong>Toma algum medicamento?</strong>
          <p class="text-muted">{{ $usuario->medicamento }}</p>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
    <div class="col-md-9">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#geral" data-toggle="tab">Geral</a></li>
          <li><a href="#financeiro" data-toggle="tab">Financeiro</a></li>
          <li><a href="#agenda" data-toggle="tab">Agenda</a></li>
        </ul>
        <div class="tab-content">
          <div class="active tab-pane" id="geral">
              <table class="table dataTable table-bordered">
                <tr>
                    <th>Endereço</th> <td>{{ $usuario->endereco }}</td>
                    <th>Nome pai</th> <td>{{ $usuario->nome_pai }}</td>
                </tr>
                <tr>
                    <th>Bairro/Cidade</th> <td>{{ $usuario->bairro }} / {{ $usuario->cidade }}</td>
                    <th>Celular pai</th> <td>{{ $usuario->cel_pai }}</td>
                </tr>
                <tr>
                    <th>RG</th> <td>{{ $usuario->rg }}</td>
                    <th>Nome mãe</th> <td>{{ $usuario->nome_mae }}</td>
                </tr>
                <tr>
                    <th>CPF</th> <td>{{ $usuario->cpf }}</td>
                    <th>Celular mãe</th> <td>{{ $usuario->cel_mae }}</td>
                </tr>
                <tr>
                    <th>Telefone res</th> <td>{{ $usuario->telefone }}</td>
                    <th>Outro responsável</th> <td>{{ $usuario->nome_outro }}</td>
                </tr>
                <tr>
                    <th>Celular</th> <td>{{ $usuario->celular }}</th>
                    <th>Celular</th> <td>{{ $usuario->cel_outro }}</td>
                </tr>
                <tr>
                    <th>Email</th> <td>{{ $usuario->email }}</td>
                    <th>Vinculo</th> <td>{{ $usuario->vinculo }}</td>
                </tr>
              </table>
          </div><!-- /.tab-pane -->

          <div class="tab-pane" id="financeiro">
              <table class="table dataTable table-bordered">
                <tr>
                    <th>Boletos em nome de</th> <td>{{ $usuario->nome_boleto }}</td>
                </tr>
                <tr>
                    <th>CPF emitido nos boletos</th> <td>{{ $usuario->cpf_boleto }}</td>
                </tr>
                <tr>
                    <th>Desconto</th> <td>{{ $usuario->desconto }}</td>
                </tr>
                <tr>
                    <th>Nome do banco</th> <td>{{ $usuario->nome_banco }}</td>
                </tr>
                <tr>
                    <th>Agência</th> <td>{{ $usuario->agencia_banco }}</td>
                </tr>
                <tr>
                    <th>N° da conta</th> <td>{{ $usuario->conta_banco }}</td>
                </tr>
              </table>
          </div><!-- /.tab-pane -->

          <div class="tab-pane" id="agenda">
            <div id="calendar"></div>
          </div><!-- /.tab-pane -->
        </div><!-- /.tab-content -->
      </div><!-- /.nav-tabs-custom -->
    </div><!-- /.col -->
  </div><!-- /.row -->
@endsection
