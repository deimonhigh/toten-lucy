<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Produtos</h4>
                    <p>Aqui você visualiza as informações do produto cadastrado.</p>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h5>Nome do Produto</h5>
                            <p><strong><?php echo e($dados->nomeproduto); ?></strong></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <h5>Código de barras</h5>
                            <p><strong><?php echo e($dados->codigobarras); ?></strong></p>
                        </div>
                        <div class="col-sm-6">
                            <h5>Código produto Ábaco</h5>
                            <p><strong><?php echo e($dados->codigoprodutoabaco); ?></strong></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <h5>Código do Produto</h5>
                            <p><strong><?php echo e($dados->codigoproduto); ?></strong></p>
                        </div>

                        <?php if(strlen($dados->codigoprodutopai) > 0): ?>
                            <div class="col-sm-6">
                                <h5>Código do Produto Pai</h5>
                                <p><strong><?php echo e($dados->codigoprodutopai); ?></strong></p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if(strlen($dados->descricao) > 0): ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <h5>Descrição</h5>
                                <p><strong><?php echo $dados->descricao; ?></strong></p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <?php if(strlen($dados->cor) > 0): ?>
                            <div class="col-sm-6">
                                <h5>Cor do Produto</h5>
                                <p><strong><?php echo e($dados->cor); ?></strong></p>
                            </div>
                        <?php endif; ?>
                        <div class="col-sm-6">
                            <h5>Peso do Produto</h5>
                            <p><strong><?php echo e($dados->peso); ?></strong></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <h5>Quantidade em estoque do Produto</h5>
                            <p><strong><?php echo e($dados->estoque); ?></strong></p>
                        </div>
                        <div class="col-sm-6">
                            <h5>Produto desabilitado?</h5>
                            <p><strong><?php echo e(($dados->disabled ? 'Sim' : 'Não')); ?></strong></p>
                        </div>
                    </div>

                    <div class="row">
                        <h3 class="col-md-12">Tabela da Precos 1</h3>
                        <div class="col-sm-6">
                            <h5>Preço do Produto</h5>
                            <p><strong><?php echo e("R$ " . number_format($dados->preco1, 2,',','.')); ?></strong></p>
                        </div>
                        <div class="col-sm-6">
                            <h5>Preço do Produto em promoção</h5>
                            <p><strong><?php echo e("R$ " . number_format($dados->precopromocao1, 2,',','.')); ?></strong></p>
                        </div>
                    </div>

                    <div class="row">
                        <h3 class="col-md-12">Tabela da Precos 2</h3>
                        <div class="col-sm-6">
                            <h5>Preço do Produto</h5>
                            <p><strong><?php echo e("R$ " . number_format($dados->preco2, 2,',','.')); ?></strong></p>
                        </div>
                        <div class="col-sm-6">
                            <h5>Preço do Produto em promoção</h5>
                            <p><strong><?php echo e("R$ " . number_format($dados->precopromocao2, 2,',','.')); ?></strong></p>
                        </div>
                    </div>

                </div><!-- panel-body -->

                <?php if(!isset($dados->imagens) || count($dados->imagens) == 0): ?>
                    <div class="panel-footer">
                        <button class="btn btn-default" onclick="window.history.back(-1);">Voltar</button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div><!-- row -->
    <?php if(isset($dados->imagens) && count($dados->imagens) > 0): ?>
        <div class="panel panel-default">

            <div class="panel-heading">
                <h4 class="panel-title">Imagens</h4>
            </div>
            <div class="panel-body">
                <div class="row filemanager">
                    <?php $__currentLoopData = $dados->imagens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-xs-6 col-sm-4 col-md-3 document">
                            <div class="thmb">
                                <div class="thmb-prev">
                                    <img src="<?php echo e(asset($image['path'])); ?>"
                                         class="img-responsive"
                                         alt=""
                                         style="margin: 0 auto; padding: 5px;" />
                                </div>
                                <small class="text-muted">
                                    Adicionada em: <?php echo e(date('d/m/Y', strtotime($image['updated_at']))); ?>

                                </small>
                            </div><!-- thmb -->
                        </div><!-- col-xs-6 -->
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div><!-- row -->
            </div>

            <div class="panel-footer">
                <button class="btn btn-default" onclick="window.history.back(-1);">Voltar</button>
            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>