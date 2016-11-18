<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset($usuarioLogado->foto == '' ? '/assets/img/default.png' : 'perfil/' . $usuarioLogado->foto ) }}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>{{ $usuarioLogado->nome }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form (Optional) -->
        <form action="{{ URL::to('/pesquisa') }}" method="post" class="sidebar-form">
            {!! csrf_field() !!}
            <div class="input-group">
                <input type="text" name="key" class="form-control" placeholder="Pesquisa rápida"/>
                <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="treeview">
                <a href="{{ URL::to('/') }}"><span>Home</span> <i class="fa fa-angle-right pull-right"></i></a>
            </li>
            <li class="header">Administrativo</li>
            <li class="treeview">
                <a href="#"><span>Usuários</span> <i class="fa fa-angle-double-down pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ URL::to('/usuarios') }}">Listagem</a></li>
                    <li><a href="{{ URL::to('/usuarios/create') }}">Cadastro</a></li>
                    <li><a href="{{ URL::to('/contratos') }}">Contratos</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><span>Cursos / Módulos / Turmas</span> <i class="fa fa-angle-double-down pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ URL::to('/turmas') }}">Listagem</a></li>
                    <li><a href="{{ URL::to('/turmas/create') }}">Nova Turma</a></li>
                    <li><a href="{{ URL::to('/modulos/create') }}">Novo Módulo</a></li>
                    <li><a href="{{ URL::to('/cursos/create') }}">Novo Curso</a></li>
                </ul>
            </li>
            <li class="header">Financeiro</li>
            <li class="treeview">
                <a href="#">
                    <span>Caixa</span> <i class="fa fa-angle-double-down pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ URL::to('/caixa/create') }}">Caixa hoje</a></li>
                    <li><a href="{{ URL::to('/caixa/extrato') }}">Extrato</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <span>Boletos</span> <i class="fa fa-angle-double-down pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ URL::to('/boletos/create') }}">Emitir boleto</a></li>
                    <li><a href="{{ URL::to('/boletos') }}">Listagem</a></li>
                    <!--li><a href="{{ URL::to('/remessa-retorno') }}">Remessa / Retorno</a></li-->
                </ul>
            </li>
            <li class="header">Acessos</li>
            <li class="treeview">
                <a href="{{ URL::to('/chamadas') }}">
                    <span>Chamada</span> <i class="fa fa-angle-right pull-right"></i>
                </a>
            </li>
            <li class="treeview">
                <a href="{{ URL::to('/pontos') }}">
                    <span>Ponto</span> <i class="fa fa-angle-right pull-right"></i>
                </a>
            </li>
            <li class="treeview">
                <a href="{{ URL::to('/acessos/manual') }}">
                    <span>Manual</span> <i class="fa fa-angle-right pull-right"></i>
                </a>
            </li>
            <li class="header">Relatórios</li>
            <li class="treeview">
                <a href="#">
                    <span>Administrativo</span> <i class="fa fa-angle-double-down pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ URL::to('/relatorios/usuarios') }}">Usuários</a></li>
                    <!--li><a href="{{ URL::to('/relatorios/cursos') }}">Cursos</a></li>
                    <li><a href="{{ URL::to('/relatorios/modulos') }}">Módulos</a></li>
                    <li><a href="{{ URL::to('/relatorios/turmas') }}">Turmas</a></li-->
                </ul>
            </li>
            <!--li class="treeview">
                <a href="#">
                    <span>Financeiro</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ URL::to('/relatorios/caixas') }}">Caixas</a></li>
                    <li><a href="{{ URL::to('/relatorios/boletos') }}">Boletos</a></li>
                </ul>
            </li-->
            <li class="treeview">
                <a href="#">
                    <span>Acessos</span> <i class="fa fa-angle-double-down pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ URL::to('/relatorios/chamadas') }}">Chamadas</a></li>
                    <li><a href="{{ URL::to('/relatorios/ponto') }}">Pontos</a></li>
                </ul>
            </li>
        </ul><!-- /.sidebar-menu -->
        <br><br>
    </section>
    <!-- /.sidebar -->
</aside>
