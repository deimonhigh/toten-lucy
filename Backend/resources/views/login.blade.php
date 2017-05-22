<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="{{ url('admin/images/favicon.png') }}" type="image/png">

    <title>Toten Lucy</title>

    <link href="{{ url('admin/css/style.default.css') }}" rel="stylesheet">
    <link href="{{ url('admin/css/style.inverse.css') }}" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Lato:400,400i,700,700i" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="{{ url('admin/js/html5shiv.js') }}"></script>
    <script src="{{ url('admin/js/respond.min.js') }}"></script>
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

                            <form method="post" class="center-block" action="{{ route('login') }}">
                                <h4 class="nomargin">
                                    <img src="{{ url('admin//images/logo.png') }}"
                                         alt="Lucy Home"
                                         class="img-responsive center-block mb30">
                                </h4>
                                <p class="mt5 mb20">Efetue login para acessar sua conta.</p>
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <input type="email"
                                           name="email"
                                           id="email"
                                           class="form-control uname"
                                           placeholder="E-mail"
                                           required
                                           autofocus />
                                    @if ($errors->has('email'))
                                        <label for="email" class="error">{{ $errors->first('email') }}</label>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <input type="password"
                                           name="password"
                                           class="form-control pword"
                                           placeholder="Senha"
                                           required />
                                    @if ($errors->has('password'))
                                        <label for="password" class="error">{{ $errors->first('password') }}</label>
                                    @endif</div>
                                <button class="btn btn-success btn-block">Entrar</button>

                            </form>
                        </div><!-- col-sm-5 -->

                    </div><!-- row -->
                </div>
            </div>
        </div><!-- signin -->

        <script src="{{ url('admin//js/jquery-1.11.1.min.js') }}"></script>
        <script src="{{ url('admin//js/jquery.sparkline.min.js') }}"></script>
        <script src="{{ url('admin//js/retina.min.js') }}"></script>
        <script src="{{ url('admin//js/custom.js') }}"></script>
    </section>
</body>
</html>
