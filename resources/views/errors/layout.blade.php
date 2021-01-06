<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <base href="{{ config('app.url') }}">

        <link rel="stylesheet" href="{{ asset('css/app.css', request()->isSecure()) }}" nonce="{{ csp_nonce() }}">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        {{-- <link rel="stylesheet"
              href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic" nonce="{{ csp_nonce() }}"> --}}

        <title>@yield('title') :: {{ config('app.display_name') }}</title>
    </head>
    <body class="hold-transition">
        <section class="content">
            <div class="error-page">
                <h2 class="headline text-danger">@yield('code')</h2>
                <div class="error-content">
                    <h3>
                        <i class="fas fa-exclamation-triangle text-danger"></i> 
                        Oops! Kesalahan terjadi pada saat akses laman tersebut.
                    </h3>

                    <h1>@yield('message')</h1>
                    <p>
                        <a href="{{ app('router')->has('home') ? route('home') : url('/') }}" class="btn btn-primary btn-sm">
                            {{ __('button.back') }}
                        </a>
                    </p>
                </div>
            </div>
        </section>
        <script src="{{ asset('js/app.js', request()->isSecure()) }}" nonce="{{ csp_nonce() }}"></script>
    </body>
</html>
