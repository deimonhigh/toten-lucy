<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Pedidos</h4>
                    <p>Aqui você confere a lista de pedidos cadastrados no momento</p>

                    <a class="btn btn-default" style="margin-top: 20px;" href="<?php echo e(url(route('naoConcluidos'))); ?>">
                        Remover não concluídos
                    </a>
                    <a class="btn btn-default" style="margin-top: 20px;" href="<?php echo e(url(route('enviarNovamente'))); ?>">
                        Enviar novamente
                    </a>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb30">
                            <thead>
                                <tr>
                                    <th>Código do pedido</th>
                                    <th>Cliente</th>
                                    <th>Documento (CPF/CNPJ)</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <?php if(count($dados) > 0): ?>
                                <?php $__currentLoopData = $dados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tbody>
                                        <tr>
                                            <td><?php echo e($data->pedido_id); ?></td>
                                            <td><?php echo e($data->cliente->nome); ?></td>
                                            <td><?php echo e($data->cliente->documento); ?></td>
                                            <td>
                                                <?php if($data->status): ?>
                                                    Enviado para KPL
                                                <?php elseif(is_null($data->total) || $data->total == 0): ?>
                                                    Pedido não concluído
                                                <?php else: ?>
                                                    Não enviado
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a class="btn btn-default"
                                                   href="<?php echo e(url(route('pedidoDetalhe', ['id' => $data->id]))); ?>">
                                                    <i class="fa fa-search"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <tbody>
                                    <tr>
                                        <td colspan="4">Nenhum pedido cadastrado no momento.</td>
                                    </tr>
                                </tbody>
                            <?php endif; ?>
                        </table>
                    </div><!-- table-responsive -->
                </div><!-- panel-body -->
                <div class="panel-footer">
                  <?php echo $dados->render(); ?>
                </div>
            </div>
        </div>

    </div><!-- row -->
<?php $__env->stopSection(); ?>


<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>