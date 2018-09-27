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
                    <h4 class="panel-title">Categorias do sistema</h4>
                    <p>Aqui você confere a lista de categorias cadastradas no momento</p>
                    <a class="btn btn-default"
                       style="margin-top: 20px;"
                       href="<?php echo e(url(route('importarCategoriasView'))); ?>">
                        Atualizar base de dados
                    </a>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb30">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Descricao</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <?php if(count($dados) > 0): ?>
                                <?php $__currentLoopData = $dados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tbody>
                                        <tr>
                                            <td><?php echo e($data->id); ?></td>
                                            <td><?php echo e($data->descricao); ?></td>
                                            <td>
                                                <a class="btn btn-default"
                                                   href="<?php echo e(url(route('categoriasEditar', ['id' => $data->id]))); ?>">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <a class="btn btn-default"
                                                   href="<?php echo e(url(route('deletarCategoria', ['id' => $data->id]))); ?>">
                                                    <i class="fa fa-close"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <tbody>
                                    <tr>
                                        <td colspan="4">Nenhum Categoria cadastrada no momento.</td>
                                    </tr>
                                </tbody>
                            <?php endif; ?>
                        </table>
                    </div><!-- table-responsive -->
                </div><!-- panel-body -->
            </div>
        </div>
    </div><!-- row -->

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Categorias do KPL</h4>
                    <p>Aqui você confere a lista de categorias importadas do KPL no momento</p>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb30">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Id KPL</th>
                                    <th>Descricao</th>
                                </tr>
                            </thead>
                            <?php if(count($dadosImportados) > 0): ?>
                                <?php $__currentLoopData = $dadosImportados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tbody>
                                        <tr>
                                            <td><?php echo e($data->id); ?></td>
                                            <td><?php echo e($data->codigocategoria); ?></td>
                                            <td><?php echo e($data->descricao); ?></td>
                                        </tr>
                                    </tbody>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <tbody>
                                    <tr>
                                        <td colspan="4">Nenhum Categoria cadastrada no momento.</td>
                                    </tr>
                                </tbody>
                            <?php endif; ?>
                        </table>
                    </div><!-- table-responsive -->
                </div><!-- panel-body -->
            </div>
        </div>
    </div><!-- row -->
<?php $__env->stopSection(); ?>


<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>