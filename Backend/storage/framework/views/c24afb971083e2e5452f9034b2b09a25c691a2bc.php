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
                <form action="<?php echo e(url(route('categoriasRelacaoCadastrar'))); ?>"
                      method="post"
                      class="validate"
                >
                    <?php echo e(csrf_field()); ?>

                    <div class="panel-heading">
                        <h4 class="panel-title">Relacionamento de categorias</h4>
                        <p>Aqui você altera as informações das categorias.</p>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Categoria cadastrada</label>
                                    <select name="admincategoria_id" class="form-control">
                                        <option value="" selected>Selecione uma categoria</option>
                                        <?php $__currentLoopData = $Admincategoria; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($admin->id); ?>"><?php echo e($admin->descricao); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php if($errors->has('Admincategoria')): ?>
                                        <label class="error">Selecione uma categoria cadastrada</label>
                                    <?php endif; ?>
                                </div>
                            </div><!-- col-sm-6 -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Categoria importada</label>
                                    <select name="categoria_id" class="form-control">
                                        <option value="" selected>Selecione uma categoria</option>
                                        <?php $__currentLoopData = $categoriasImportadas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($admin->id); ?>"><?php echo e($admin->id .  ' - ' . $admin->descricao); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php if($errors->has('categoriasImportadas')): ?>
                                        <label class="error">Selecione uma categoria importada</label>
                                    <?php endif; ?>
                                </div>
                            </div><!-- col-sm-6 -->
                        </div>

                        <div class="table-responsive">
                            <table class="table mb30">
                                <thead>
                                    <tr>
                                        <th>Categoria cadastrada</th>
                                        <th>Categoria importada</th>
                                    </tr>
                                </thead>
                                <?php if($dados): ?>
                                    <tbody>
                                        <?php $__currentLoopData = $Admincategoria; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyParent => $valParent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $__currentLoopData = $valParent->categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr <?php if($keyParent % 2 == 0): ?> class="active" <?php endif; ?>>
                                                    <?php if($key == 0): ?>
                                                        <td rowspan="<?php echo e(count($valParent->categorias)); ?>"><?php echo e($valParent->descricao); ?></td>
                                                    <?php endif; ?>
                                                    <td>
                                                        <?php echo e($val->descricao); ?>

                                                    </td>
                                                    <td>
                                                        <a class="btn btn-default"
                                                           title="Remover relacionamento"
                                                           href="<?php echo e(url(route('relacionarDeletar', ['idCatAdmin' => $val->pivot->admincategoria_id, 'idCat' => $val->pivot->categoria_id]))); ?>">
                                                            <i class="fa fa-close"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                <?php else: ?>
                                    <tbody>
                                        <tr>
                                            <td colspan="4">Nenhum relacionamento cadastrada no momento.</td>
                                        </tr>
                                    </tbody>
                                <?php endif; ?>
                            </table>
                        </div><!-- table-responsive -->

                    </div><!-- panel-body -->
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>

    </div><!-- row -->
<?php $__env->stopSection(); ?>


<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>