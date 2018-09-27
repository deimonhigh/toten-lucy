<div class="leftpanelinner">
    <h5 class="sidebartitle">Menu</h5>
    <ul class="nav nav-pills nav-stacked nav-bracket">
        <li @if($menu == 'dashboard') class="active" @endif>
            <a href="{{ url(route('home')) }}">
                <i class="fa fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li @if($menu == 'clientes') class="active" @endif>
            <a href="{{ url(route('clientes')) }}">
                <i class="fa fa-suitcase"></i>
                <span>Clientes</span>
            </a>
        </li>

        <li @if($menu == 'produtos') class="active" @endif>
            <a href="{{ url(route('produtos')) }}">
                <i class="fa fa-glass"></i>
                <span>Produtos</span>
            </a>
        </li>

        @if(\App\Gate::hasAccess('admin/categorias'))
            <li class="nav-parent @if($menu == 'categorias') active @endif">
                <a href="javascript:void (0);">
                    <i class="fa fa-tags"></i>
                    <span>Categorias</span>
                </a>
                <ul class="children" @if($menu == 'categorias') style="display: block;" @endif>
                    <li @if($menu == 'categorias' && $submenu == 'listagem') class="active" @endif>
                        <a href="{{ url(route('listagemCategoria')) }}">
                            <i class="fa fa-caret-right"></i>
                            Listagem
                        </a>
                    </li>

                    <li @if($menu == 'categorias' && $submenu == 'cadastrar') class="active" @endif>
                        <a href="{{ url(route('categoriasCadastro')) }}">
                            <i class="fa fa-caret-right"></i>
                            Cadastrar
                        </a>
                    </li>

                    <li @if($menu == 'categorias' && $submenu == 'relacionar') class="active" @endif>
                        <a href="{{ url(route('categoriasRelacao')) }}">
                            <i class="fa fa-caret-right"></i>
                            Relacionar
                        </a>
                    </li>
                </ul>
            </li>
        @endif
        <li @if($menu == 'pedidos') class="active" @endif>
            <a href="{{ url(route('pedidos')) }}">
                <i class="fa fa-money"></i>
                <span>Pedidos</span>
            </a>
        </li>

        <li class="nav-parent @if($menu == 'vendedores') active @endif">
            <a href="javascript:void (0);">
                <i class="fa fa-address-card"></i>
                <span>Vendedores</span>
            </a>
            <ul class="children" @if($menu == 'vendedores') style="display: block;" @endif>
                <li @if($menu == 'vendedores' && $submenu == 'listagem') class="active" @endif>
                    <a href="{{ url(route('vendedores')) }}">
                        <i class="fa fa-caret-right"></i>
                        Listagem
                    </a>
                </li>
                <li @if($menu == 'vendedores' && $submenu == 'cadastro') class="active" @endif>
                    <a href="{{ url(route('vendedoresCadastro')) }}">
                        <i class="fa fa-caret-right"></i>
                        Cadastrar
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-parent @if($menu == 'config') active @endif">
            <a href="javascript:void (0);">
                <i class="fa fa-gear"></i>
                <span>Configurações</span>
            </a>
            <ul class="children" @if($menu == 'config') style="display: block;" @endif>
                <li @if($menu == 'config' && $submenu == 'tema') class="active" @endif>
                    <a href="{{ url(route('config')) }}">
                        <i class="fa fa-caret-right"></i>
                        Identificação
                    </a>
                </li>
                <li @if($menu == 'config' && $submenu == 'banner') class="active" @endif>
                    <a href="{{ url(route('banner')) }}">
                        <i class="fa fa-caret-right"></i>
                        Banner promocional
                    </a>
                </li>
                @if(\App\Gate::hasAccess('admin/lojas'))
                    <li @if($menu == 'config' && $submenu == 'parcelas') class="active" @endif>
                        <a href="{{ url(route('parcelas')) }}">
                            <i class="fa fa-caret-right"></i>
                            Parcelas
                        </a>
                    </li>
                @endif
            </ul>
        </li>

        @if(\App\Gate::hasAccess('admin/lojas'))
            <li class="nav-parent @if($menu == 'lojas') active @endif">
                <a href="javascript:void (0);">
                    <i class="fa fa-shopping-basket"></i>
                    <span>Lojas</span>
                </a>
                <ul class="children" @if($menu == 'lojas') style="display: block;" @endif>
                    <li @if($menu == 'lojas' && $submenu == 'listagem') class="active" @endif>
                        <a href="{{ url(route('lojas')) }}">
                            <i class="fa fa-caret-right"></i>
                            Listagem
                        </a>
                    </li>
                    <li @if($menu == 'lojas' && $submenu == 'cadastro') class="active" @endif>
                        <a href="{{ url(route('lojasCadastro')) }}">
                            <i class="fa fa-caret-right"></i>
                            Cadastrar
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if(\App\Gate::hasAccess('admin/usuarios'))
            <li class="nav-parent @if($menu == 'usuarios') active @endif">
                <a href="javascript:void (0);">
                    <i class="fa fa-user"></i>
                    <span>Usuários</span>
                </a>
                <ul class="children" @if($menu == 'usuarios') style="display: block;" @endif>
                    <li @if($menu == 'usuarios' && $submenu == 'listagem') class="active" @endif>
                        <a href="{{ url(route('usuarios')) }}">
                            <i class="fa fa-caret-right"></i>
                            Listagem
                        </a>
                    </li>
                    <li @if($menu == 'usuarios' && $submenu == 'cadastro') class="active" @endif>
                        <a href="{{ url(route('usuariosCadastro')) }}">
                            <i class="fa fa-caret-right"></i>
                            Cadastrar
                        </a>
                    </li>
                </ul>
            </li>
        @endif

    </ul>

</div><!-- leftpanelinner -->