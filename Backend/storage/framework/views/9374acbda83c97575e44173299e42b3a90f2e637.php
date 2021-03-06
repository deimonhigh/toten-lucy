<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Pedido <strong><?php echo e($dados->pedidos_id); ?></strong></h4>
                    <p>Aqui você visualiza as informações dos clientes cadastrados.</p>
                </div>
                <div class="panel-body">

                    <h3 class="bbottom">Dados do cliente</h3>
                    <div class="row">
                        <div class="col-sm-6">
                            <h5>Nome</h5>
                            <p><strong><?php echo e($dados->cliente->nome); ?></strong></p>
                        </div>
                        <div class="col-sm-6">
                            <h5>Documento CPF/CNPJ</h5>
                            <p><strong><?php echo e($dados->cliente->documento); ?></strong></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <h5>Data de solicitação do pedido</h5>
                            <p><strong><?php echo e(date('d/m/Y', strtotime($dados->created_at))); ?></strong></p>
                        </div>
                    </div>

                    <?php if($dados->cliente->enderecos && count($dados->cliente->enderecos) > 0): ?>
                        <h3 class="bbottom">Endereço(s)</h3>
                        <?php $__currentLoopData = $dados->cliente->enderecos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $endereco): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <h4>Endereço <?php echo e($key + 1); ?></h4>
                            <div class="row">
                                <div class="col-sm-6">
                                    <h5>CEP</h5>
                                    <p><strong><?php echo e($endereco->cep); ?></strong></p>
                                </div>
                                <div class="col-sm-6">
                                    <h5>Endereço</h5>
                                    <p><strong><?php echo e($endereco->endereco); ?>, <?php echo e($endereco->numero); ?></strong></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <h5>Complemento</h5>
                                    <p><strong><?php echo e($endereco->complemento); ?></strong></p>
                                </div>
                                <div class="col-sm-6">
                                    <h5>Bairro</h5>
                                    <p><strong><?php echo e($endereco->bairro); ?></strong></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <h5>Cidade</h5>
                                    <p><strong><?php echo e($endereco->cidade); ?></strong></p>
                                </div>
                                <div class="col-sm-6">
                                    <h5>Estado</h5>
                                    <p><strong><?php echo e($endereco->uf); ?></strong></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <h5>Endereço de entrega</h5>
                                    <p>
                                        <strong>
                                            <?php if($endereco->enderecooriginal): ?>
                                                Sim
                                            <?php else: ?>
                                                Não
                                            <?php endif; ?>
                                        </strong>
                                    </p>
                                </div>
                            </div>
                            <?php if($key != 1): ?>
                                <hr>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>

                    <?php if(count($dados->produtos) > 0): ?>
                        <h3 class="bbottom">Produtos</h3>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-striped">
                                    <thead>
                                        <th>
                                            ID
                                        </th>
                                        <th>
                                            Código do produto
                                        </th>
                                        <th>
                                            Nome do produto
                                        </th>
                                        <th>
                                            Preço unitário
                                        </th>
                                        <th>
                                            Quantidade
                                        </th>
                                        <th>
                                            Preço Total
                                        </th>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $dados->produtos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>
                                                    <?php echo e($produto->produto->id); ?>

                                                </td>
                                                <td>
                                                    <?php echo e($produto->produto->codigoproduto); ?>

                                                </td>
                                                <td>
                                                    <?php echo e($produto->produto->nomeproduto); ?>

                                                </td>
                                                <td>
                                                    <?php echo e('R$' . number_format($produto->produto->preco, 2, ',', '.')); ?>

                                                </td>
                                                <td>
                                                    <?php echo e($produto->quantidade); ?>

                                                </td>
                                                <td>
                                                    <?php echo e('R$' . number_format(($produto->quantidade * $produto->produto->preco), 2, ',', '.')); ?>

                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>

                    <h3 class="bbottom">Dados do vendedor</h3>
                    <div class="row">
                        <div class="col-sm-12">
                            <h5>Nome</h5>
                            <p><strong><?php echo e($dados->vendedor->nome); ?></strong></p>
                        </div>
                    </div>

                    <h3 class="bbottom">Dados do pedido</h3>
                    <div class="row">
                        <div class="col-sm-6">
                            <h5>Total sem juros</h5>
                            <p><strong><?php echo e('R$' . number_format($dados->total , 2, ',', '.')); ?></strong></p>
                        </div>
                        <div class="col-sm-6">
                            <h5>Total a pagar</h5>
                            <p><strong><?php echo e('R$' . number_format($dados->totalComJuros, 2, ',', '.')); ?></strong></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <h5>Total com Frete</h5>
                            <p><strong><?php echo e('R$' . number_format($dados->totalComFrete, 2, ',', '.')); ?></strong></p>
                        </div>
                        <div class="col-sm-6">
                            <h5>Número de parcelas</h5>
                            <?php if($dados->parcelas): ?>
                                <p><strong><?php echo e($dados->parcelas); ?></strong></p>
                            <?php else: ?>
                                <p><strong>À vista</strong></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if(!is_null($dados->comprovante) && strlen($dados->comprovante) > 0): ?>
                        <div class="row">
                            <?php if(strpos($dados->comprovante, '.')): ?>
                                <div class="col-sm-3">
                                    <h5>Comprovante</h5>
                                    <p>
                                        <a href="<?php echo e(asset(str_replace('public', 'storage', $dados->comprovante))); ?>"
                                           download>
                                            <img src="<?php echo e(asset(str_replace('public', 'storage', $dados->comprovante))); ?>"
                                                 class="img-responsive"
                                                 alt="<?php echo e($dados->cliente->nome); ?>"
                                                 style="width: 100%; margin-top: 20px;">
                                        </a>
                                    </p>
                                </div>
                            <?php else: ?>
                                <div class="col-sm-12">
                                    <h5>Comprovante</h5>
                                    <p>
                                        <strong>Comprovante MercadoPago: <?php echo e($dados->comprovante); ?></strong>
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if(count($dados->comprovantes) > 0): ?>
                            <h3 class="bbottom">Códigos de comprovantes</h3>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-striped">
                                        <thead>
                                            <th>
                                                Código
                                            </th>
                                            <th>
                                                Bandeira
                                            </th>
                                            <th>
                                                Loja
                                            </th>
                                            <th>
                                                Vendedor
                                            </th>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $dados->comprovantes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comprovante): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td>
                                                        <?php echo e($comprovante->codigo); ?>

                                                    </td>
                                                    <td>
                                                        <?php echo e(strcmp($comprovante->bandeira, 'aVista') ? "À vista" : $comprovante->bandeira); ?>

                                                    </td>
                                                    <td>
                                                        <?php echo e($comprovante->user->name); ?>

                                                    </td>
                                                    <td>
                                                        <?php echo e($comprovante->vendedor->nome); ?>

                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php endif; ?>

                    <?php endif; ?>
                </div><!-- panel-body -->
                <div class="panel-footer">
                    <button class="btn btn-default" onclick="window.history.back(-1);">Voltar</button>
                </div>
            </div>
        </div>

    </div><!-- row -->
<?php $__env->stopSection(); ?>


<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>