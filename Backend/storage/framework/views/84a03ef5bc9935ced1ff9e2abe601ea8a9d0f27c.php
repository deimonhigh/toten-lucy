<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <form action="<?php echo e(url(route('lojasCadastrar'))); ?>" method="post" class="validate">
                    <?php echo e(csrf_field()); ?>

                    <input type="hidden"
                           name="id"
                           value="<?php if(isset($dados->id)): ?> <?php echo e($dados->id); ?> <?php endif; ?>">
                    <div class="panel-heading">
                        <h4 class="panel-title">Cadastro de Lojas</h4>
                        <p>Aqui você altera as informações dos Lojas.</p>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Nome</label>
                                    <input type="text"
                                           name="name"
                                           class="form-control"
                                           required
                                           value="<?php if(isset($dados->name)): ?> <?php echo e($dados->name); ?> <?php elseif(old('name')): ?> <?php echo e(old('name')); ?> <?php endif; ?>" />
                                    <?php if($errors->has('name')): ?>
                                        <label class="error">Campo Nome é obrigatório.</label>
                                    <?php endif; ?>
                                </div>
                            </div><!-- col-sm-6 -->
                        </div><!-- row -->

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">E-mail</label>
                                    <input type="text"
                                           name="email"
                                           class="form-control"
                                           required
                                           value="<?php if(isset($dados->email)): ?> <?php echo e($dados->email); ?> <?php elseif(old('email')): ?> <?php echo e(old('email')); ?> <?php endif; ?>"
                                    />
                                    <?php if($errors->has('email')): ?>
                                        <label class="error"><?php echo e($errors->first('email')); ?></label>
                                    <?php endif; ?>
                                </div>
                            </div><!-- col-sm-6 -->
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Lista de Preços</label>
                                    <select name="listaPreco" class="form-control">
                                        <option value="1" <?php if($dados->listaPreco == 1): ?> selected <?php endif; ?>>Lista de Precos 1
                                                                                                       (TABELA_LOJA)
                                        </option>
                                        <option value="2" <?php if($dados->listaPreco == 2): ?> selected <?php endif; ?>>Lista de Precos 2
                                                                                                       (TABELA DE
                                                                                                       PRECOS)
                                        </option>
                                    </select>
                                </div>
                            </div><!-- col-sm-6 -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Utiliza Mercado Pago</label>
                                    <select name="mercadoPago" class="form-control">
                                        <option value="1" <?php if($dados->mercado_pago == 1): ?> selected <?php endif; ?>>Sim
                                        </option>
                                        <option value="0" <?php if($dados->mercado_pago == 0): ?> selected <?php endif; ?>>Não
                                        </option>
                                    </select>
                                </div>
                            </div><!-- col-sm-6 -->
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Senha</label>
                                    <input type="password"
                                           name="password"
                                           class="form-control"
                                    />
                                    <?php if($errors->has('password')): ?>
                                        <label class="error">Campo senha é obrigatório.</label>
                                    <?php endif; ?>
                                </div>
                            </div><!-- col-sm-6 -->

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Confirmar a Senha</label>
                                    <input type="password"
                                           name="password_confirmation"
                                           class="form-control"
                                    />
                                    <?php if($errors->has('password_confirmation')): ?>
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