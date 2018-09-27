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
                <form action="<?php echo e(url(route('freteCadastrar'))); ?>"
                      method="post"
                      class="validate"
                      enctype="multipart/form-data">
                    <?php echo e(csrf_field()); ?>

                    <div class="panel-heading">
                        <h4 class="panel-title">Lista de fretes</h4>
                        <p>Cadastre a nova lista de fretes.</p>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group" style="position: relative;">
                                    <label class="control-label" style="display: block;">Lista de fretes</label>
                                    <input type="file"
                                           name="listaFretes"
                                           class="form-control"
                                    />
                                    <?php if($errors->has('listaFretes')): ?>
                                        <label class="error"><?php echo e(str_replace('lista fretes', 'Lista de Fretes', $errors->first('listaFretes'))); ?></label>
                                    <?php endif; ?>
                                </div>
                            </div><!-- col-sm-6 -->
                        </div><!-- row -->

                    </div><!-- panel-body -->
                    <div class="panel-footer">
                        <button type="submit" name="action" value="save" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>

    </div><!-- row -->
<?php $__env->stopSection(); ?>


<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>