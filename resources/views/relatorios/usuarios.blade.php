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
            <form role="form" action="{{ url('/relatorios/usuarios') }}" method="post">
                <div class="box-body">
                    {!! csrf_field() !!}
                    <div class="box-body">  
                        <h3 class="box-title">Dados Pessoais</h3>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label>
                                    <input class="minimal" name="nome" type="checkbox">
                                    Nome
                                </label>
                            </div>
                            <div class="form-group col-md-2">
                                <label>
                                    <input class="minimal" name="nascimento" type="checkbox">
                                    Data de nascimento
                                </label>
                            </div>
                            <div class="form-group col-md-2">
                                <label>
                                    <input class="minimal" name="rg" type="checkbox">
                                    RG
                                </label>
                            </div>
                            <div class="form-group col-md-2">
                                <label>
                                    <input class="minimal" name="cpf" type="checkbox">
                                    CPF
                                </label>
                            </div>
                            <div class="form-group col-md-2">
                                <label>
                                    <input class="minimal" name="matricula" type="checkbox">
                                    Matricula
                                </label>
                            </div>
                            <div class="form-group col-md-2">
                                <label>
                                    <input class="minimal" name="nivel" type="checkbox">
                                    Nivel
                                </label>
                            </div>
                        </div>
                        
                        <h3 class="box-title">Saúde</h3>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label>
                                    <input class="minimal" name="emerg_nome" type="checkbox">
                                    Em caso de emergência, entrar em contato com:
                                </label>
                            </div>
                            <div class="form-group col-md-2">
                                <label>
                                    <input class="minimal" name="emerg_telefone" type="checkbox">
                                    Telefone para emergências
                                </label>
                            </div>
                            <div class="form-group col-md-2">
                                <label>
                                    <input class="minimal" name="problema_saude" type="checkbox">
                                    Possui algum problema de saúde? Qual?
                                </label>
                            </div>
                            <div class="form-group col-md-2">
                                <label>
                                    <input class="minimal" name="alergia" type="checkbox">
                                    Possui algum tipo de alergia? Qual?
                                </label>
                            </div>
                            <div class="form-group col-md-2">
                                <label>
                                    <input class="minimal" name="medicamento" type="checkbox">
                                    Toma algum medicamento? Qual?
                                </label>
                            </div>
                        </div>
                        
                        <h3 class="box-title">Financeiro</h3>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label>
                                    <input class="minimal" name="nome_boleto" type="checkbox">
                                    Boletos em nome de:
                                </label>
                            </div>
                            <div class="form-group col-md-2">
                                <label>
                                    <input class="minimal" name="cpf_boleto" type="checkbox">
                                    CPF emitido nos boletos
                                </label>
                            </div>
                            <div class="form-group col-md-2">
                                <label>
                                    <input class="minimal" name="desconto" type="checkbox">
                                    Desconto
                                </label>
                            </div>
                            <div class="form-group col-md-2">
                                <label>
                                    <input class="minimal" name="nome_banco" type="checkbox">
                                    Nome do banco
                                </label>
                            </div>
                            <div class="form-group col-md-2">
                                <label>
                                    <input class="minimal" name="agencia_banco" type="checkbox">
                                    Agência
                                </label>
                            </div>
                            <div class="form-group col-md-2">
                                <label>
                                    <input class="minimal" name="conta_banco" type="checkbox">
                                    N° da conta
                                </label>
                            </div>
                        </div>
                        
                        <h3 class="box-title">Contato</h3>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label>
                                    <input class="minimal" name="telefone" type="checkbox">
                                    Telefone residencial
                                </label>
                            </div>
                            <div class="form-group col-md-2">
                                <label>
                                    <input class="minimal" name="celular" type="checkbox">
                                    Telefone celular
                                </label>
                            </div>
                            <div class="form-group col-md-2">
                                <label>
                                    <input class="minimal" name="email" type="checkbox">
                                    Email
                                </label>
                            </div>
                            <div class="form-group col-md-2">
                                <label>
                                    <input class="minimal" name="nome_pai" type="checkbox">
                                    Nome do pai
                                </label>
                            </div>
                            <div class="form-group col-md-2">
                                <label>
                                    <input class="minimal" name="cel_pai" type="checkbox">
                                    Celular do pai
                                </label>
                            </div>
                            <div class="form-group col-md-2">
                                <label>
                                    <input class="minimal" name="nome_mae" type="checkbox">
                                    Nome da mãe
                                </label>
                            </div>
                            <div class="form-group col-md-2">
                                <label>
                                    <input class="minimal" name="cel_mae" type="checkbox">
                                    Celular da mãe
                                </label>
                            </div>
                            <div class="form-group col-md-2">
                                <label>
                                    <input class="minimal" name="nome_outro" type="checkbox">
                                    Outro responsável
                                </label>
                            </div>
                            <div class="form-group col-md-2">
                                <label>
                                    <input class="minimal" name="cel_outro" type="checkbox">
                                    Celular
                                </label>
                            </div>
                            <div class="form-group col-md-2">
                                <label>
                                    <input class="minimal" name="vinculo" type="checkbox">
                                    Vínculo com o aluno
                                </label>
                            </div>
                            <div class="form-group col-md-2">
                                <label>
                                    <input class="minimal" name="email_resp" type="checkbox">
                                    Email responsável
                                </label>
                            </div>
                            <div class="form-group col-md-2">
                                <label>
                                    <input class="minimal" name="endereco" type="checkbox">
                                    Endereço
                                </label>
                            </div>
                            <div class="form-group col-md-2">
                                <label>
                                    <input class="minimal" name="bairro" type="checkbox">
                                    Bairro
                                </label>
                            </div>
                            <div class="form-group col-md-2">
                                <label>
                                    <input class="minimal" name="cidade" type="checkbox">
                                    Cidade
                                </label>
                            </div>
                            <div class="form-group col-md-2">
                                <label>
                                    <input class="minimal" name="cep" type="checkbox">
                                    CEP
                                </label>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="form-group col-md-3">
                        <label>Busca por</label>
                        <select name="busca_por" class="form-control">
                            <option value="data_cadastro">Data de cadastro</option>
                            <option value="turmas_relac">Turmas relacionadas</option>
                        </select>
                    </div>
                    
                    <div class="form-group col-md-3">
                        <label>Nivel</label>
                        <select name="busca_nivel" class="form-control">
                            <option value="">Todos</option>
                            <option value="aluno">Aluno</option>
                            <option value="aluno_prof">Aluno / Professor</option>
                            <option value="prof_func">Professor / Funcionário</option>
                        </select>
                    </div>
                    
                    <div class="form-group col-md-2">
                        <label for="cadastro">De </label>
                        <input class="form-control formDate" name="periodo_de">
                    </div>
                    
                    <div class="form-group col-md-2">
                        <label for="cadastro">Até </label>
                        <input class="form-control formDate" name="periodo_ate">
                    </div>
                    <div class="form-group col-md-2">
                        <br>
                        <button type="submit" class="btn btn-primary">Gerar relatório</button>
                    </div>
                </div>
            </form>
        </div><!-- /.box -->
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection
