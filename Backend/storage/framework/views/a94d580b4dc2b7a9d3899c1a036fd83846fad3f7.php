<div class="headerbar">

    <a class="menutoggle"><i class="fa fa-bars"></i></a>

    <div class="header-right">
        <ul class="headermenu">
            <li>
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php echo e(url('adminpanel/images/user.svg')); ?>" alt="Usuário logado" />
                        <?php echo e(Auth::user()->name); ?>

                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                        <li>
                            <a href="<?php echo e(url(route('perfil'))); ?>"><i class="glyphicon glyphicon-user"></i>Meu perfil</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('logout')); ?>"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="glyphicon glyphicon-log-out"></i> Sair
                            </a>

                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                <?php echo e(csrf_field()); ?>

                            </form>
                    </ul>
                </div>
            </li>
        </ul>
    </div><!-- header-right -->

</div><!-- headerbar -->
