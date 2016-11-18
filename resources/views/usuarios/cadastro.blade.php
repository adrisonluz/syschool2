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
    <div class='col-md-6'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Dados pessoais</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ url('/usuarios') }}" method="post">
                {!! csrf_field() !!}
                <div class="box-body">
                    <div class="form-group">
                        <label for="cadastro">Nome</label>
                        <input class="form-control"  name="nome" placeholder="Nome" type="text">
                    </div>
                    <div class="form-group">
                        <label for="cadastro">Data de nascimento</label>
                        <input class="form-control formDate" name="nascimento" placeholder="Data de nascimento">
                    </div>
                    <div class="form-group">
                        <label for="cadastro">RG</label>
                        <input class="form-control" name="rg" placeholder="RG" type="text">
                    </div>
                    <div class="form-group">
                        <label for="cadastro">CPF</label>
                        <input class="form-control formCPF" name="cpf" placeholder="CPF" type="text">
                    </div>
                </div><!-- /.box-body -->
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Acesso</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label for="cadastro">Matricula</label>
                    <input class="form-control" name="login" placeholder="Matricula" type="text">
                </div>
                <div class="form-group">
                    <label for="cadastro">Senha</label>
                    <input class="form-control" name="password" placeholder="Senha" type="password">
                </div>
                <div class="form-group">
                    <label>Nível</label>
                    <select name="nivel" class="form-control">
                        <option value="aluno">Aluno</option>
                        <option value="aluno_prof">Aluno / Professor</option>
                        <option value="prof_func">Professor / Funcionário</option>
                        <option value="sec">Secretaría</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>
                <div class="box-footer">
                    Dados de acesso são importantes para serem usados no caso de o usuário esquecer ou perder seu acesso.
                </div>
            </div><!-- /.box-body -->
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Saúde</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label for="cadastro">Em caso de emergência, entrar em contato com:</label>
                    <input class="form-control" name="emerg_nome" placeholder="Nome do contato" type="text">
                </div>
                <div class="form-group">
                    <label for="cadastro">Telefone para emergências</label>
                    <input class="form-control formFone" name="emerg_telefone" placeholder="Telefone para emergências" type="text">
                </div>
                <div class="form-group">
                    <label for="cadastro">Possui algum problema de saúde? Qual?</label>
                    <input class="form-control" name="problema_saude" placeholder="Se sim, diga qual" type="text">
                </div>
                <div class="form-group">
                    <label for="cadastro">Possui algum tipo de alergia? Qual?</label>
                    <input class="form-control" name="alergia" placeholder="Se sim, diga qual" type="text">
                </div>
                <div class="form-group">
                    <label for="cadastro">Toma algum medicamento? Qual?</label>
                    <input class="form-control" name="medicamento" placeholder="Se sim, diga qual" type="text">
                </div>
                <div class="box-footer">
                    Específicar quais medicamentos e tratamentos quando houver. Não esquecer de registrar o período ou horário dos medicamentos.
                </div>
            </div><!-- /.box-body -->
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Financeiro</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label for="cadastro">Boletos em nome de:</label>
                    <input class="form-control" name="nome_boleto" placeholder="Nome emitido nos boletos" type="text">
                </div>
                <div class="form-group">
                    <label for="cadastro">CPF emitido nos boletos</label>
                    <input class="form-control formCPF" name="cpf_boleto" placeholder="CPF emitido nos boletos" type="text">
                </div>
                <div class="form-group">
                    <label>Desconto</label>
                    <select name="desconto" class="form-control">
                        <option value="">Nenhum</option>
                        <option value="familia">Desconto família</option>
                        <option value="fidelidade">Desconto fidelidade</option>
                        <option value="auxilio">Bolsa auxílio</option>
                        <option value="integral">Bolsa integral</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="cadastro">Nome do banco</label>
                    <input class="form-control" name="nome_banco" placeholder="Banco" type="text">
                </div>
                <div class="form-group">
                    <label for="cadastro">Agência</label>
                    <input class="form-control" name="agencia_banco" placeholder="Agência" type="text">
                </div>
                <div class="form-group">
                    <label for="cadastro">N° da conta</label>
                    <input class="form-control" name="conta_banco" placeholder="N° da conta" type="text">
                </div>
                <div class="box-footer">
                    Dados bancários só são necessários se o usuário for funcionário da escola.
                </div>
            </div><!-- /.box-body -->
        </div>
    </div><!-- /.col -->

    <div class='col-md-6'>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Imagem</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="input-group input-group-sm">
                    <input class="form-control" name="foto" type="text" value="">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-info btn-flat" id="btn-camera" data-toggle="modal" data-target="#modalCamera"><i class="fa fa-camera"></i></button>
                    </span>
                </div>
                <div id="imagem-preview"><canvas id="canvas" width="400" height="300"></canvas></div>
                <input type="hidden" name="codImagem" value=""> 
            </div><!-- /.box-body -->
            <div class="box-footer">
                Clique na câmera e depois em 'ok' para tirar uma foto.
            </div>
        </div>

        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Contato</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label for="cadastro">Telefone residencial</label>
                    <input class="form-control formFone" name="telefone" placeholder="Telefone residencial" type="text">
                </div>
                <div class="form-group">
                    <label for="cadastro">Telefone celular</label>
                    <input class="form-control formFone" name="celular" placeholder="Telefone celular" type="text">
                </div>
                <div class="form-group">
                    <label for="cadastro">Email</label>
                    <input class="form-control formEmail" name="email" placeholder="Email" type="text">
                </div>
                <div class="form-group">
                    <label for="cadastro">Nome do pai</label>
                    <input class="form-control" name="nome_pai" placeholder="Nome do pai" type="text">
                </div>
                <div class="form-group">
                    <label for="cadastro">Celular do pai</label>
                    <input class="form-control formFone" name="cel_pai" placeholder="Celular do pai" type="text">
                </div>
                <div class="form-group">
                    <label for="cadastro">Nome da mãe</label>
                    <input class="form-control" name="nome_mae" placeholder="Nome da mãe" type="text">
                </div>
                <div class="form-group">
                    <label for="cadastro">Celular da mãe</label>
                    <input class="form-control formFone" name="cel_mae" placeholder="Celular da mãe" type="text">
                </div>
                <div class="form-group">
                    <label for="cadastro">Outro responsável</label>
                    <input class="form-control" name="nome_outro" placeholder="Nome" type="text">
                </div>
                <div class="form-group">
                    <label for="cadastro">Celular</label>
                    <input class="form-control formFone" name="cel_outro" placeholder="Celular" type="text">
                </div>
                <div class="form-group">
                    <label for="vinculo">Vínculo com o aluno</label>
                    <input class="form-control" name="vinculo" placeholder="O que este responsável é do aluno?" type="text">
                </div>
                <div class="form-group">
                    <label for="cadastro">Email do responsável</label>
                    <input class="form-control formEmail" name="email_resp" placeholder="Email do responsável" type="text">
                </div>
                <div class="form-group">
                    <label for="cadastro">Endereço</label>
                    <input class="form-control" name="endereco" placeholder="Endereço" type="text">
                </div>
                <div class="form-group">
                    <label for="cadastro">Bairro</label>
                    <input class="form-control" name="bairro" placeholder="Bairro" type="text">
                </div>
                <div class="form-group">
                    <label for="cadastro">Cidade</label>
                    <input class="form-control" name="cidade" placeholder="Cidade" type="text">
                </div>
                <div class="form-group">
                    <label for="cadastro">CEP</label>
                    <input class="form-control formCEP" name="cep" placeholder="CEP" type="text">
                </div>
            </div>
        </div><!-- /.box -->

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Adicional</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label>Observações</label>
                    <textarea name="observacoes" class="form-control" rows="3" placeholder="Observações ..."></textarea>
                </div>
                <div class="form-group verTurmas">
                    <label>Turmas</label>
                    @if(count($turmas) > 0)
                    @foreach($turmas as $turma)
                    <div class="checkbox">
                        <label><input type="checkbox" name="turmas[]" value="{{ $turma->id }}" >&nbsp;{{ $turma->curso->nome }} | {{ $turma->professor->nome }}</label>
                    </div>
                    @endforeach
                    @else
                    <p>Não há turmas cadastradas.</p>
                    @endif
                </div>
            </div>
            <div class="box-footer">
                <button type="button" class="btn btn-success verTurmas">Ver turmas</button>
                <button type="submit" class="btn btn-primary pull-right">Cadastrar</button>
            </div>
        </div>
        </form>
    </div><!-- /.col -->

</div><!-- /.row -->
@endsection

<div class="modal fade" id="modalCamera" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">×</span></button>
                <h3 class="box-title">Preview</strong></h3>
            </div>
            <div class="modal-body">
                <video id="video" autoplay></video>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary btn-block" id="okFoto" data-dismiss="modal" value="ok"><b>OK</b></a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
