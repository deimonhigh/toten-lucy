<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Lojas</h4>
                    <p>Aqui você confere a lista de lojas cadastradas no momento</p>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb30">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nome do Usuário</th>
                                    <th>E-mail</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <?php if(count($dados) > 0): ?>
                                <?php $__currentLoopData = $dados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tbody>
                                        <tr>
                                            <td><?php echo e($data->id); ?></td>
                                            <td><?php echo e($data->name); ?></td>
                                            <td><?php echo e($data->email); ?></td>
                                            <td>
                                                <a class="btn btn-default"
                                                   title="Detalhes do Loja"
                                                   href="<?php echo e(url(route('lojasDetalhe', ['id' => $data->id]))); ?>">
                                                    <i class="fa fa-search"></i>
                                                </a>

                                                <a class="btn btn-default"
                                                   title="Editar Loja"
                                                   href="<?php echo e(url(route('lojasEditar', ['id' => $data->id]))); ?>">
                                                    <i class="fa fa-pencil"></i>
                                                </a>

                                                <a class="btn btn-default"
                                                   title="Excluir Loja"
                                                   href="<?php echo e(url(route('lojasDeletar', ['id' => $data->id]))); ?>">
                                                    <i class="fa fa-close"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <tbody>
                                    <tr>
                                        <td colspan="4">Nenhuma loja cadastrada no momento.</td>
                                    </tr>
                                </tbody>
                            <?php endif; ?>
                        </table>
                    </div><!-- table-responsive -->
                </div><!-- panel-body -->
                <div class="panel-footer">
                    <div class="row">
                        <?php echo e($dados->render()); ?>

                    </div>
                </div>
            </div>
        </div>

    </div><!-- row -->
<?php $__env->stopSection(); ?>


<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>