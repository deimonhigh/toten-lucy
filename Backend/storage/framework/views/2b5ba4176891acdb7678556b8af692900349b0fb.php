<div class="leftpanelinner">
    <h5 class="sidebartitle">Menu</h5>
    <ul class="nav nav-pills nav-stacked nav-bracket">
        <li <?php if($menu == 'dashboard'): ?> class="active" <?php endif; ?>>
            <a href="<?php echo e(url(route('home'))); ?>">
                <i class="fa fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li <?php if($menu == 'clientes'): ?> class="active" <?php endif; ?>>
            <a href="<?php echo e(url(route('clientes'))); ?>">
                <i class="fa fa-suitcase"></i>
                <span>Clientes</span>
            </a>
        </li>

        <li <?php if($menu == 'produtos'): ?> class="active" <?php endif; ?>>
            <a href="<?php echo e(url(route('produtos'))); ?>">
                <i class="fa fa-glass"></i>
                <span>Produtos</span>
            </a>
        </li>

        <?php if(\App\Gate::hasAccess('admin/categorias')): ?>
            <li class="nav-parent <?php if($menu == 'categorias'): ?> active <?php endif; ?>">
                <a href="javascript:void (0);">
                    <i class="fa fa-tags"></i>
                    <span>Categorias</span>
                </a>
                <ul class="children" <?php if($menu == 'categorias'): ?> style="display: block;" <?php endif; ?>>
                    <li <?php if($menu == 'categorias' && $submenu == 'listagem'): ?> class="active" <?php endif; ?>>
                        <a href="<?php echo e(url(route('listagemCategoria'))); ?>">
                            <i class="fa fa-caret-right"></i>
                            Listagem
                        </a>
                    </li>

                    <li <?php if($menu == 'categorias' && $submenu == 'cadastrar'): ?> class="active" <?php endif; ?>>
                        <a href="<?php echo e(url(route('categoriasCadastro'))); ?>">
                            <i class="fa fa-caret-right"></i>
                            Cadastrar
                        </a>
                    </li>

                    <li <?php if($menu == 'categorias' && $submenu == 'relacionar'): ?> class="active" <?php endif; ?>>
                        <a href="<?php echo e(url(route('categoriasRelacao'))); ?>">
                            <i class="fa fa-caret-right"></i>
                            Relacionar
                        </a>
                    </li>
                </ul>
            </li>
        <?php endif; ?>
        <li <?php if($menu == 'pedidos'): ?> class="active" <?php endif; ?>>
            <a href="<?php echo e(url(route('pedidos'))); ?>">
                <i class="fa fa-money"></i>
                <span>Pedidos</span>
            </a>
        </li>

        <li class="nav-parent <?php if($menu == 'vendedores'): ?> active <?php endif; ?>">
            <a href="javascript:void (0);">
                <i class="fa fa-address-card"></i>
                <span>Vendedores</span>
            </a>
            <ul class="children" <?php if($menu == 'vendedores'): ?> style="display: block;" <?php endif; ?>>
                <li <?php if($menu == 'vendedores' && $submenu == 'listagem'): ?> class="active" <?php endif; ?>>
                    <a href="<?php echo e(url(route('vendedores'))); ?>">
                        <i class="fa fa-caret-right"></i>
                        Listagem
                    </a>
                </li>
                <li <?php if($menu == 'vendedores' && $submenu == 'cadastro'): ?> class="active" <?php endif; ?>>
                    <a href="<?php echo e(url(route('vendedoresCadastro'))); ?>">
                        <i class="fa fa-caret-right"></i>
                        Cadastrar
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-parent <?php if($menu == 'config'): ?> active <?php endif; ?>">
            <a href="javascript:void (0);">
                <i class="fa fa-gear"></i>
                <span>Configurações</span>
            </a>
            <ul class="children" <?php if($menu == 'config'): ?> style="display: block;" <?php endif; ?>>
                <li <?php if($menu == 'config' && $submenu == 'tema'): ?> class="active" <?php endif; ?>>
                    <a href="<?php echo e(url(route('config'))); ?>">
                        <i class="fa fa-caret-right"></i>
                        Identificação
                    </a>
                </li>
                <li <?php if($menu == 'config' && $submenu == 'banner'): ?> class="active" <?php endif; ?>>
                    <a href="<?php echo e(url(route('banner'))); ?>">
                        <i class="fa fa-caret-right"></i>
                        Banner promocional
                    </a>
                </li>
                <?php if(\App\Gate::hasAccess('admin/lojas')): ?>
                    <li <?php if($menu == 'config' && $submenu == 'parcelas'): ?> class="active" <?php endif; ?>>
                        <a href="<?php echo e(url(route('parcelas'))); ?>">
                            <i class="fa fa-caret-right"></i>
                            Parcelas
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </li>

        <?php if(\App\Gate::hasAccess('admin/lojas')): ?>
            <li class="nav-parent <?php if($menu == 'lojas'): ?> active <?php endif; ?>">
                <a href="javascript:void (0);">
                    <i class="fa fa-shopping-basket"></i>
                    <span>Lojas</span>
                </a>
                <ul class="children" <?php if($menu == 'lojas'): ?> style="display: block;" <?php endif; ?>>
                    <li <?php if($menu == 'lojas' && $submenu == 'listagem'): ?> class="active" <?php endif; ?>>
                        <a href="<?php echo e(url(route('lojas'))); ?>">
                            <i class="fa fa-caret-right"></i>
                            Listagem
                        </a>
                    </li>
                    <li <?php if($menu == 'lojas' && $submenu == 'cadastro'): ?> class="active" <?php endif; ?>>
                        <a href="<?php echo e(url(route('lojasCadastro'))); ?>">
                            <i class="fa fa-caret-right"></i>
                            Cadastrar
                        </a>
                    </li>
                </ul>
            </li>
        <?php endif; ?>

        <?php if(\App\Gate::hasAccess('admin/usuarios')): ?>
            <li class="nav-parent <?php if($menu == 'usuarios'): ?> active <?php endif; ?>">
                <a href="javascript:void (0);">
                    <i class="fa fa-user"></i>
                    <span>Usuários</span>
                </a>
                <ul class="children" <?php if($menu == 'usuarios'): ?> style="display: block;" <?php endif; ?>>
                    <li <?php if($menu == 'usuarios' && $submenu == 'listagem'): ?> class="active" <?php endif; ?>>
                        <a href="<?php echo e(url(route('usuarios'))); ?>">
                            <i class="fa fa-caret-right"></i>
                            Listagem
                        </a>
                    </li>
                    <li <?php if($menu == 'usuarios' && $submenu == 'cadastro'): ?> class="active" <?php endif; ?>>
                        <a href="<?php echo e(url(route('usuariosCadastro'))); ?>">
                            <i class="fa fa-caret-right"></i>
                            Cadastrar
                        </a>
                    </li>
                </ul>
            </li>
        <?php endif; ?>

    </ul>

</div><!-- leftpanelinner -->