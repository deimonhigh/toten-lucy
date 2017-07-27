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
                <form action="<?php echo e(url(route('cadastrarParcelas'))); ?>"
                      method="post"
                      class="validate"
                >
                    <?php echo e(csrf_field()); ?>

                    <input type="hidden"
                           name="id"
                           value="<?php if(isset($dados->id)): ?> <?php echo e($dados->id); ?> <?php elseif(old('id')): ?> <?php echo e(old('id')); ?> <?php endif; ?>">
                    <div class="panel-heading">
                        <h4 class="panel-title">Parcelas</h4>
                        <p>Cadastre os juros referentes a quantidade de parcelas a serem aplicadas nos preços da
                           aplicação.</p>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Parcelamento máximo</label>
                                    <select name="max_parcelas" class="form-control">
                                        <?php for($i = 1; $i < 13; $i++): ?>
                                            <option value="<?php echo e($i); ?>"
                                                    <?php if($dados->max_parcelas == $i): ?> selected <?php endif; ?>><?php echo e($i); ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div><!-- col-sm-6 -->
                        </div><!-- row -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">À vista (em %) </label>
                                    <input type="text"
                                           name="parcela0"
                                           class="form-control"
                                           value="<?php if(isset($dados->parcela0)): ?> <?php echo e($dados->parcela0); ?> <?php elseif(old('parcela0')): ?> <?php echo e(old('parcela0')); ?> <?php endif; ?>"
                                    />
                                </div>
                            </div><!-- col-sm-6 -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Juros da parcela 1 (em %) </label>
                                    <input type="text"
                                           name="parcela1"
                                           class="form-control"
                                           value="<?php if(isset($dados->parcela1)): ?> <?php echo e($dados->parcela1); ?> <?php elseif(old('parcela1')): ?> <?php echo e(old('parcela1')); ?> <?php endif; ?>"
                                    />
                                </div>
                            </div><!-- col-sm-6 -->
                        </div><!-- row -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Juros da parcela 2 (em %) </label>
                                    <input type="text"
                                           name="parcela2"
                                           class="form-control"
                                           value="<?php if(isset($dados->parcela2)): ?> <?php echo e($dados->parcela2); ?> <?php elseif(old('parcela2')): ?> <?php echo e(old('parcela2')); ?> <?php endif; ?>"
                                    />
                                </div>
                            </div><!-- col-sm-6 -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Juros da parcela 3 (em %) </label>
                                    <input type="text"
                                           name="parcela3"
                                           class="form-control"
                                           value="<?php if(isset($dados->parcela3)): ?> <?php echo e($dados->parcela3); ?> <?php elseif(old('parcela3')): ?> <?php echo e(old('parcela3')); ?> <?php endif; ?>"
                                    />
                                </div>
                            </div><!-- col-sm-6 -->
                        </div><!-- row -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Juros da parcela 4 (em %) </label>
                                    <input type="text"
                                           name="parcela4"
                                           class="form-control"
                                           value="<?php if(isset($dados->parcela4)): ?> <?php echo e($dados->parcela4); ?> <?php elseif(old('parcela4')): ?> <?php echo e(old('parcela4')); ?> <?php endif; ?>"
                                    />
                                </div>
                            </div><!-- col-sm-6 -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Juros da parcela 5 (em %) </label>
                                    <input type="text"
                                           name="parcela5"
                                           class="form-control"
                                           value="<?php if(isset($dados->parcela5)): ?> <?php echo e($dados->parcela5); ?> <?php elseif(old('parcela5')): ?> <?php echo e(old('parcela5')); ?> <?php endif; ?>"
                                    />
                                </div>
                            </div><!-- col-sm-6 -->
                        </div><!-- row -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Juros da parcela 6 (em %) </label>
                                    <input type="text"
                                           name="parcela6"
                                           class="form-control"
                                           value="<?php if(isset($dados->parcela6)): ?> <?php echo e($dados->parcela6); ?> <?php elseif(old('parcela6')): ?> <?php echo e(old('parcela6')); ?> <?php endif; ?>"
                                    />
                                </div>
                            </div><!-- col-sm-6 -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Juros da parcela 7 (em %) </label>
                                    <input type="text"
                                           name="parcela7"
                                           class="form-control"
                                           value="<?php if(isset($dados->parcela7)): ?> <?php echo e($dados->parcela7); ?> <?php elseif(old('parcela7')): ?> <?php echo e(old('parcela7')); ?> <?php endif; ?>"
                                    />
                                </div>
                            </div><!-- col-sm-6 -->
                        </div><!-- row -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Juros da parcela 8 (em %) </label>
                                    <input type="text"
                                           name="parcela8"
                                           class="form-control"
                                           value="<?php if(isset($dados->parcela8)): ?> <?php echo e($dados->parcela8); ?> <?php elseif(old('parcela8')): ?> <?php echo e(old('parcela8')); ?> <?php endif; ?>"
                                    />
                                </div>
                            </div><!-- col-sm-6 -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Juros da parcela 9 (em %) </label>
                                    <input type="text"
                                           name="parcela9"
                                           class="form-control"
                                           value="<?php if(isset($dados->parcela9)): ?> <?php echo e($dados->parcela9); ?> <?php elseif(old('parcela9')): ?> <?php echo e(old('parcela9')); ?> <?php endif; ?>"
                                    />
                                </div>
                            </div><!-- col-sm-6 -->
                        </div><!-- row -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Juros da parcela 10 (em
                                                                                      %) </label>
                                    <input type="text"
                                           name="parcela10"
                                           class="form-control"
                                           value="<?php if(isset($dados->parcela10)): ?> <?php echo e($dados->parcela10); ?> <?php elseif(old('parcela10')): ?> <?php echo e(old('parcela10')); ?> <?php endif; ?>"
                                    />
                                </div>
                            </div><!-- col-sm-6 -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Juros da parcela 11 (em
                                                                                      %) </label>
                                    <input type="text"
                                           name="parcela11"
                                           class="form-control"
                                           value="<?php if(isset($dados->parcela11)): ?> <?php echo e($dados->parcela11); ?> <?php elseif(old('parcela11')): ?> <?php echo e(old('parcela11')); ?> <?php endif; ?>"
                                    />
                                </div>
                            </div><!-- col-sm-6 -->
                        </div><!-- row -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Juros da parcela 12 (em
                                                                                      %) </label>
                                    <input type="text"
                                           name="parcela12"
                                           class="form-control"
                                           value="<?php if(isset($dados->parcela12)): ?> <?php echo e($dados->parcela12); ?> <?php elseif(old('parcela12')): ?> <?php echo e(old('parcela12')); ?> <?php endif; ?>"
                                    />
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