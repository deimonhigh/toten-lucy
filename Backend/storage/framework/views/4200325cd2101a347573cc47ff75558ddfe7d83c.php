<?php $__env->startSection('content'); ?>
    <div class="row">

        <div class="col-sm-6 col-md-4">
            <div class="panel panel-dark panel-stat">
                <div class="panel-heading">

                    <div class="stat" style="max-width: 100%">
                        <div class="row">
                            <div class="col-xs-3">
                                <img src="<?php echo e(url('adminpanel/images/is-money.png')); ?>"
                                     alt="" />
                            </div>
                            <div class="col-xs-8">
                                <small class="stat-label">Quantidade de pedidos</small>
                                <h1><?php echo e($qntPedidos); ?></h1>
                            </div>
                        </div><!-- row -->

                        <div class="mb15"></div>

                        <div class="row">
                            <div class="col-xs-6">
                                <small class="stat-label">Total de pedidos</small>
                                <h4><?php echo e('R$' . number_format($somaTotalPedidos, 2, ',', '.')); ?></h4>
                            </div>

                            <div class="col-xs-6">
                                <small class="stat-label">Total de pedidos enviados ao KPL</small>
                                <h4><?php echo e('R$' . number_format($somaTotalPedidosEnviados, 2, ',', '.')); ?></h4>
                            </div>
                        </div><!-- row -->

                    </div><!-- stat -->

                </div><!-- panel-heading -->
            </div><!-- panel -->
        </div><!-- col-sm-6 -->

        <div class="col-sm-6 col-md-4">
            <div class="panel panel-success panel-stat">
                <div class="panel-heading">

                    <div class="stat" style="max-width: 100%">
                        <div class="row">
                            <div class="col-xs-3">
                                <img src="<?php echo e(url('adminpanel/images/is-money.png')); ?>"
                                     alt="" />
                            </div>
                            <div class="col-xs-8">
                                <small class="stat-label">Quantidade de pedidos mês atual</small>
                                <h1><?php echo e($qntPedidosEsteMes); ?></h1>
                            </div>
                        </div><!-- row -->

                        <div class="mb15"></div>

                        <div class="row">
                            <div class="col-xs-6">
                                <small class="stat-label">Total de pedidos</small>
                                <h4><?php echo e('R$' . number_format($somaPedidosEsteMes, 2, ',', '.')); ?></h4>
                            </div>
                        </div><!-- row -->

                    </div><!-- stat -->

                </div><!-- panel-heading -->
            </div><!-- panel -->
        </div><!-- col-sm-6 -->

        <div class="col-sm-6 col-md-4">
            <div class="panel panel-danger panel-stat">
                <div class="panel-heading">

                    <div class="stat" style="max-width: 100%">
                        <div class="row">
                            <div class="col-xs-3">
                                <img src="<?php echo e(url('adminpanel/images/is-money.png')); ?>"
                                     alt="" />
                            </div>
                            <div class="col-xs-8">
                                <small class="stat-label">Quantidade de pedidos do mês passado</small>
                                <h1><?php echo e($qntPedidosMesPassado); ?></h1>
                            </div>
                        </div><!-- row -->

                        <div class="mb15"></div>

                        <div class="row">
                            <div class="col-xs-6">
                                <small class="stat-label">Total de pedidos</small>
                                <h4><?php echo e('R$' . number_format($somaPedidosMesPassado, 2, ',', '.')); ?></h4>
                            </div>
                        </div><!-- row -->

                    </div><!-- stat -->

                </div><!-- panel-heading -->
            </div><!-- panel -->
        </div><!-- col-sm-6 -->
    </div><!-- row -->

    <div class="row">

        <div class="col-sm-6 col-md-4">
            <div class="panel panel-primary panel-stat">
                <div class="panel-heading">

                    <div class="stat" style="max-width: 100%">
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-xs-12">
                                <small class="stat-label">Atualização de Produtos</small>
                                <h4><?php if(!$datas || is_null($datas->produtos)): ?>"Não
                                                                             atualizado" <?php else: ?> <?php echo e($datas->produtos); ?> <?php endif; ?></h4>
                            </div>
                        </div><!-- row -->

                        <div class="row">
                            <div class="col-xs-12">
                                <small class="stat-label">Atualização de Pedidos</small>
                                <h4><?php if(!$datas || is_null($datas->pedidos)): ?>"Não
                                                                            atualizado" <?php else: ?> <?php echo e($datas->pedidos); ?> <?php endif; ?></h4>
                            </div>
                        </div><!-- row -->
                    </div><!-- stat -->

                </div><!-- panel-heading -->
            </div><!-- panel -->
        </div><!-- col-sm-6 -->
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>