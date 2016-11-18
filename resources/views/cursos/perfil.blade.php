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
          <img class="profile-user-img img-responsive img-circle" src="{{ asset('assets/img/curso.png') }}" alt="{{ $curso->nome }}">
          <h3 class="profile-username text-center">{{ $curso->nome }}</h3>

          <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
              <b>Quatidade de aulas:</b> <a class="pull-right">{{ $curso->qtd_aulas }}</a>
            </li>
          </ul>

          <a href="{{ url('cursos/' . $curso->id . '/edit') }}" class="btn btn-primary btn-block"><b>Editar</b></a>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->

    <div class="col-md-9">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#turmas" data-toggle="tab">Turmas relacionadas</a></li>
          <li><a href="#alunos" data-toggle="tab">Alunos relacionados</a></li>
          <li><a href="#professores" data-toggle="tab">Professores relacionados</a></li>
        </ul>
        <div class="tab-content">
          <div class="active tab-pane" id="turmas">

          </div><!-- /.tab-pane -->

          <div class="active tab-pane" id="alunos">

          </div><!-- /.tab-pane -->

          <div class="active tab-pane" id="professores">

          </div><!-- /.tab-pane -->
        </div><!-- /.tab-content -->
      </div><!-- /.nav-tabs-custom -->
    </div><!-- /.col -->
  </div><!-- /.row -->
@endsection
