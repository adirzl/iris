<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('css/app.css', request()->isSecure()) }}" nonce="{{ csp_nonce() }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"
        nonce="{{ csp_nonce() }}">

    <title>@yield('title') :: {{ config('app.display_name') }}</title>
</head>

<body class="hold-transition login-page" style="background: url(../img/2958636.png) no-repeat center fixed;  -webkit-background-size: cover;
-moz-background-size: cover;
-o-background-size: cover;
background-size: cover;
">
    <div class="login-box" style="margin-right: 1000px;
    margin-bottom: 150px;">
        <div class="login-logo">
            <!-- <img src="{{ asset('img/logo.png') }}" alt="" width="140" height="80"> -->
            <h4 style="font-size: 40px; color:#ffcc56;"><strong>{{ config('app.display_name') }}</strong></h4>
        </div>

        @include('layouts.partials.message')

        <div class="card">
            <div class="vard-body login-card-body">
                <p class="login-box-msg">@yield('title')</p>
                @yield('content')
            </div>
        </div>
    </div>
    <script src="{{ asset('js/app.js', request()->isSecure()) }}" nonce="{{ csp_nonce() }}"></script>
</body>

</html>
