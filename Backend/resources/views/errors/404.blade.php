<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="{{ url('adminpanel/images/favicon.png') }}" type="image/png">

    <title>Toten Lucy</title>

    <link href="{{ url('adminpanel/css/style.default.css') }}" rel="stylesheet">
    <link href="{{ url('adminpanel/css/style.inverse.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('adminpanel/css/colorpicker.css') }}" />
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="{{ url('adminpanel/js/html5shiv.js') }}"></script>
    <script src="{{ url('adminpanel/js/respond.min.js') }}"></script>
    <![endif]-->

    <link href="https://fonts.googleapis.com/css?family=Lato:400,400i,700,700i" rel="stylesheet">
</head>

<body class="notfound">

    <section>

        <div class="notfoundpanel">
            <h1>404!</h1>
            <h3>A página que você esta procurando não foi encontrada!</h3>
            <h4>A página que você esta procurando pode ter sido removida, ter tido seu nome trocado ou esta
                indisponível.</h4>
            <a href="{{ url(route('home')) }}" class="btn btn-success">Inicio</a>
            <a href="javascript:window.history.go(-1);" class="btn btn-success">Voltar</a>
        </div><!-- notfoundpanel -->

    </section>

    @include('parts.footer')

</body>
</html>
