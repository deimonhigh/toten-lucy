<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale')); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo e(url('adminpanel/images/favicon.png')); ?>" type="image/png">

    <title>Toten Lucy</title>

    <link href="<?php echo e(url('adminpanel/css/style.default.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(url('adminpanel/css/style.inverse.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(url('adminpanel/css/colorpicker.css')); ?>" />
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo e(url('adminpanel/js/html5shiv.js')); ?>"></script>
    <script src="<?php echo e(url('adminpanel/js/respond.min.js')); ?>"></script>
    <![endif]-->

    <link href="https://fonts.googleapis.com/css?family=Lato:400,400i,700,700i" rel="stylesheet">
</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
    </div>

    <section>

        <div class="leftpanel">

            <div class="logopanel">
                <h1><span>[</span> Toten Lucy <span>]</span></h1>
            </div><!-- logopanel -->
            <?php echo $__env->make('parts.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div><!-- leftpanel -->

        <div class="mainpanel">

            <?php echo $__env->make('parts.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <?php echo $__env->make('parts.breadcrumb', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <div class="contentpanel">
                <?php echo $__env->yieldContent('content'); ?>
            </div><!-- contentpanel -->

        </div><!-- mainpanel -->

    </section>

    <?php echo $__env->make('parts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

</body>
</html>
