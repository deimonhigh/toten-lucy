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
                    <h4 class="panel-title">Produtos</h4>
                    <p>Aqui você confere a lista de produtos cadastrados no momento</p>
                    <?php if(\App\Gate::hasAccess('admin/produtos/importarProdutosView')): ?>
                        <a class="btn btn-default"
                           style="margin-top: 20px;"
                           href="<?php echo e(url(route('importarProdutos'))); ?>">
                            Atualizar base de dados
                        </a>
                    <?php endif; ?>
                    <?php if(\App\Gate::hasAccess('admin/lojas/frete')): ?>
                        <a class="btn btn-default"
                           style="margin-top: 20px;"
                           href="<?php echo e(url(route('frete'))); ?>">
                            Importar Lista de Fretes
                        </a>
                    <?php endif; ?>
                </div>

                <div class="panel-body">
                    <form method="get">
                        <div class="form-group">
                            <input type="text"
                                   name="pesquisa"
                                   placeholder="Pesquisar por Nome, código ou código de barras do produto"
                                   class="form-control"
                                   value="<?php echo e(isset($_GET['pesquisa']) ? $_GET['pesquisa'] : ''); ?>">
                        </div>
                    </form>
                </div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb30">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nome do Produto</th>
                                    <th>Código do Produto</th>
                                    <th>Código de barras</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <?php if(count($dados) > 0): ?>
                                <?php $__currentLoopData = $dados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tbody>
                                        <tr>
                                            <td><?php echo e($data->id); ?></td>
                                            <td><?php echo e($data->nomeproduto); ?></td>
                                            <td><?php echo e($data->codigoproduto); ?></td>
                                            <td><?php echo e($data->codigobarras); ?></td>
                                            <td>
                                                <a class="btn btn-default"
                                                   title="Detalhes de produtos"
                                                   href="<?php echo e(url(route('produtosDetalhe', ['id' => $data->id]))); ?>">
                                                    <i class="fa fa-search"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <tbody>
                                    <tr>
                                        <td colspan="4">Nenhum produto cadastrado no momento.</td>
                                    </tr>
                                </tbody>
                            <?php endif; ?>
                        </table>
                    </div><!-- table-responsive -->
                </div><!-- panel-body -->
                <div class="panel-footer">
                    <?php echo e($dados->appends(['pesquisa' => (isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '')])->render()); ?>

                </div>
            </div>
        </div>

    </div><!-- row -->
<?php $__env->stopSection(); ?>


<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>