<div class="pageheader">
    <h2><i class="fa <?php echo e($icon); ?>"></i> <?php echo e($current); ?> <?php if(isset($comment)): ?> <span><?php echo e($comment); ?></span> <?php endif; ?> </h2>
    <div class="breadcrumb-wrapper">
        <span class="label">Você esta aqui:</span>
        <ol class="breadcrumb">
            <li><a href="<?php echo e(url($url)); ?>"><?php echo e($parent); ?></a></li>
            <li class="active"><?php echo e($current); ?></li>
        </ol>
    </div>
</div>