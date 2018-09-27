<?php $__env->startSection('content'); ?>

    <?php if(\Session::has('success')): ?>
        <div class="alert alert-success">
            <ul style="list-style: none; padding: 0;">
                <li><?php echo \Session::get('success'); ?></li>
            </ul>
        </div>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Vendedores</h4>
                    <p>Aqui você confere a lista de vendedores cadastrados no momento</p>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb30">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nome do vendedor</th>
                                    <th>Códido de identificação</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <?php if(count($dados) > 0): ?>
                                <?php $__currentLoopData = $dados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tbody>
                                        <tr>
                                            <td><?php echo e($data->id); ?></td>
                                            <td><?php echo e($data->nome); ?></td>
                                            <td><?php echo e($data->identificacao); ?></td>
                                            <td>
                                                <a class="btn btn-default"
                                                   title="Detalhes do Vendedor"
                                                   href="<?php echo e(url(route('vendedoresDetalhe', ['id' => $data->id]))); ?>">
                                                    <i class="fa fa-search"></i>
                                                </a>

                                                <a class="btn btn-default"
                                                   title="Editar Vendedor"
                                                   href="<?php echo e(url(route('vendedoresEditar', ['id' => $data->id]))); ?>">
                                                    <i class="fa fa-pencil"></i>
                                                </a>

                                                <a class="btn btn-default"
                                                   title="Excluir Vendedor"
                                                   href="<?php echo e(url(route('vendedoresDeletar', ['id' => $data->id]))); ?>">
                                                    <i class="fa fa-close"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <tbody>
                                    <tr>
                                        <td colspan="4">Nenhum vendedor cadastrado no momento.</td>
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