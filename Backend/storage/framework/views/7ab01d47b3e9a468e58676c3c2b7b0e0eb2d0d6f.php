<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <form action="<?php echo e(url(route('vendedoresCadastrar'))); ?>" method="post" class="validate">
                    <?php echo e(csrf_field()); ?>

                    <input type="hidden"
                           name="id"
                           value="<?php if(isset($dados->id)): ?> <?php echo e($dados->id); ?> <?php endif; ?>">
                    <div class="panel-heading">
                        <h4 class="panel-title">Cadastro de vendedor</h4>
                        <p>Aqui você altera as informações dos vendedores.</p>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Nome do vendedor</label>
                                    <input type="text"
                                           name="nome"
                                           class="form-control"
                                           required
                                           value="<?php if(isset($dados->nome)): ?> <?php echo e($dados->nome); ?> <?php elseif(old('nome')): ?> <?php echo e(old('nome')); ?> <?php endif; ?>" />
                                    <?php if($errors->has('nome')): ?>
                                        <label class="error"><?php echo e($errors->first('nome')); ?></label>
                                    <?php endif; ?>
                                </div>
                            </div><!-- col-sm-6 -->
                        </div><!-- row -->

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Códido de identificação</label>
                                    <input type="text"
                                           name="identificacao"
                                           class="form-control"
                                           required
                                           value="<?php if(isset($dados->identificacao)): ?> <?php echo e($dados->identificacao); ?> <?php elseif(old('identificacao')): ?> <?php echo e(old('identificacao')); ?> <?php endif; ?>"
                                    />
                                    <?php if($errors->has('identificacao')): ?>
                                        <label class="error"><?php echo e($errors->first('identificacao')); ?></label>
                                    <?php endif; ?>
                                </div>
                            </div><!-- col-sm-6 -->
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Senha</label>
                                    <input type="password"
                                           name="senha"
                                           class="form-control"
                                    />
                                    <?php if($errors->has('senha')): ?>
                                        <label class="error"><?php echo e($errors->first('senha')); ?></label>
                                    <?php endif; ?>
                                </div>
                            </div><!-- col-sm-6 -->

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Confirmar a senha</label>
                                    <input type="password"
                                           name="senha_confirmation"
                                           class="form-control"
                                    />
                                    <?php if($errors->has('senha_confirmation')): ?>
                                        <label class="error">Campos de senha não conferem.</label>
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