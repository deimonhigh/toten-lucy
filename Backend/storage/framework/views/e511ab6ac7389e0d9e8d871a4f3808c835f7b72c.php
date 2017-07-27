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
                    <h4 class="panel-title">Usuários</h4>
                    <p>Aqui você confere a lista de usuários cadastrados no momento</p>
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
                                                <?php if($data->id !=  Auth::id()): ?>
                                                    <a class="btn btn-default"
                                                       title="Detalhes do Usuários"
                                                       href="<?php echo e(url(route('usuariosDetalhe', ['id' => $data->id]))); ?>">
                                                        <i class="fa fa-search"></i>
                                                    </a>
                                                    <a class="btn btn-default"
                                                       title="Editar Usuários"
                                                       href="<?php echo e(url(route('usuariosEditar', ['id' => $data->id]))); ?>">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>

                                                    <a class="btn btn-default"
                                                       title="Excluir Usuários"
                                                       href="<?php echo e(url(route('usuariosDeletar', ['id' => $data->id]))); ?>">
                                                        <i class="fa fa-close"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <a class="btn btn-default"
                                                       title="Detalhes do Usuários"
                                                       href="<?php echo e(url(route('perfil'))); ?>">
                                                        <i class="fa fa-search"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <tbody>
                                    <tr>
                                        <td colspan="4">Nenhum usuário cadastrado no momento.</td>
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