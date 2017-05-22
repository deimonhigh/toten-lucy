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
    <link rel="stylesheet" href="{{ url('admin/css/colorpicker.css') }}" />
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="{{ url('admin/js/html5shiv.js') }}"></script>
    <script src="{{ url('admin/js/respond.min.js') }}"></script>
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
            @include('parts.menu')
        </div><!-- leftpanel -->

        <div class="mainpanel">

            @include('parts.header')

            @include('parts.breadcrumb')

            <div class="contentpanel">
                @yield('content')
            </div><!-- contentpanel -->

        </div><!-- mainpanel -->

    </section>

    @include('parts.footer')

</body>
</html>
