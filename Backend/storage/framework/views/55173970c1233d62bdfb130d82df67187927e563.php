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
                <form action="<?php echo e(url('admin/configuracao/cadastrar')); ?>"
                      method="post"
                      class="validate"
                      enctype="multipart/form-data">
                    <?php echo e(csrf_field()); ?>

                    <input type="hidden"
                           name="id"
                           value="<?php if(isset($dados->id)): ?> <?php echo e($dados->id); ?> <?php elseif(old('id')): ?> <?php echo e(old('id')); ?> <?php endif; ?>">
                    <div class="panel-heading">
                        <h4 class="panel-title">Configurações</h4>
                        <p>Cadastre as alterações para a aplicação.</p>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Nome da empresa</label>
                                    <input type="text"
                                           name="empresa"
                                           class="form-control"
                                           required
                                           value="<?php if(isset($dados->empresa)): ?> <?php echo e($dados->empresa); ?> <?php elseif(old('empresa')): ?> <?php echo e(old('empresa')); ?> <?php endif; ?>" />
                                    <?php if($errors->has('empresa')): ?>
                                        <label class="error"><?php echo e($errors->first('empresa')); ?></label>
                                    <?php endif; ?>
                                </div>
                            </div><!-- col-sm-6 -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Cor de identificação</label>
                                    <input type="text"
                                           name="cor"
                                           style="background-color: <?php echo e($dados->cor); ?>; color: #fff;"
                                           class="form-control"
                                           id="colorpicker"
                                           required
                                           value="<?php if(isset($dados->cor)): ?> <?php echo e($dados->cor); ?> <?php elseif(old('cor')): ?> <?php echo e(old('cor')); ?> <?php endif; ?>"
                                    />
                                    <?php if($errors->has('cor')): ?>
                                        <label class="error"><?php echo e($errors->first('cor')); ?></label>
                                    <?php endif; ?>
                                </div>
                            </div><!-- col-sm-6 -->
                        </div><!-- row -->

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