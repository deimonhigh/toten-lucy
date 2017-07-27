<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <form action="<?php echo e(url(route('categoriasCadastrar'))); ?>"
                      method="post"
                      class="validate"
                      enctype="multipart/form-data">
                    <?php echo e(csrf_field()); ?>

                    <input type="hidden"
                           name="id"
                           value="<?php if(isset($dados->id)): ?> <?php echo e($dados->id); ?> <?php endif; ?>">
                    <div class="panel-heading">
                        <h4 class="panel-title">Cadastro de categorias</h4>
                        <p>Aqui você altera as informações das categorias.</p>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Categoria</label>
                                    <input type="text"
                                           name="descricao"
                                           class="form-control"
                                           required
                                           value="<?php if(isset($dados->descricao)): ?> <?php echo e($dados->descricao); ?> <?php elseif(old('descricao')): ?> <?php echo e(old('descricao')); ?> <?php endif; ?>" />
                                    <?php if($errors->has('descricao')): ?>
                                        <label class="error"><?php echo e($errors->first('descricao')); ?></label>
                                    <?php endif; ?>
                                </div>
                            </div><!-- col-sm-6 -->
                        </div><!-- row -->

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Imagem da categoria</label>
                                    <?php if(isset($dados) && $dados->imagem): ?>
                                        <img src="<?php echo e($dados->imagem); ?>"
                                             alt="<?php echo e($dados->descricao); ?>"
                                             style="max-width: 200px; margin: 10px;">
                                    <?php endif; ?>
                                    <input type="file"
                                           name="imagem"
                                           class="form-control"
                                           required
                                    />
                                    <?php if($errors->has('imagem')): ?>
                                        <label class="error"><?php echo e($errors->first('imagem')); ?></label>
                                    <?php endif; ?>
                                </div>
                            </div><!-- col-sm-6 -->
                        </div>

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