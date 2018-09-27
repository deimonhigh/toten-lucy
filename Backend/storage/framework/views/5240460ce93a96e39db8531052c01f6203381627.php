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

    <link href="https://fonts.googleapis.com/css?family=Lato:400,400i,700,700i" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo e(url('adminpanel/js/html5shiv.js')); ?>"></script>
    <script src="<?php echo e(url('adminpanel/js/respond.min.js')); ?>"></script>
    <![endif]-->
</head>

<body class="signin">
    <!-- Preloader -->
    <div id="preloader">
        <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
    </div>

    <section>
        <div class="signinpanel">
            <div class="tableHolder">
                <div class="tCell">
                    <div class="row">
                        <div class="col-md-6 center-block noFloat">

                            <form method="post" class="center-block" action="<?php echo e(route('login')); ?>">
                                <h4 class="nomargin">
                                    <img src="<?php echo e(url('adminpanel//images/logo.png')); ?>"
                                         alt="Lucy Home"
                                         class="img-responsive center-block mb30">
                                </h4>
                                <p class="mt5 mb20">Efetue login para acessar sua conta.</p>
                                <?php echo e(csrf_field()); ?>

                                <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                                    <input type="email"
                                           name="email"
                                           id="email"
                                           class="form-control uname"
                                           placeholder="E-mail"
                                           required
                                           autofocus />
                                    <?php if($errors->has('email')): ?>
                                        <label for="email" class="error"><?php echo e($errors->first('email')); ?></label>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                                    <input type="password"
                                           name="password"
                                           class="form-control pword"
                                           placeholder="Senha"
                                           required />
                                    <?php if($errors->has('password')): ?>
                                        <label for="password" class="error"><?php echo e($errors->first('password')); ?></label>
                                    <?php endif; ?></div>
                                <button class="btn btn-success btn-block">Entrar</button>

                            </form>
                        </div><!-- col-sm-5 -->

                    </div><!-- row -->
                </div>
            </div>
        </div><!-- signin -->

        <script src="<?php echo e(url('adminpanel//js/jquery-1.11.1.min.js')); ?>"></script>
        <script src="<?php echo e(url('adminpanel//js/jquery.sparkline.min.js')); ?>"></script>
        <script src="<?php echo e(url('adminpanel//js/retina.min.js')); ?>"></script>
        <script src="<?php echo e(url('adminpanel//js/custom.js')); ?>"></script>
    </section>
</body>
</html>
