<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base href="{{ config('app.url') }}">
    <script src="{{ asset('chartjs/code/highcharts.js') }}"></script>
    <script src="{{ asset('chartjs/code/modules/exporting.js') }}"></script>
    <script src="{{ asset('chartjs/code/modules/export-data.js') }}"></script>
    <script src="{{ asset('chartjs/code/modules/accessibility.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css', request()->isSecure()) }}">
    <link rel="stylesheet" href="{{ asset('css/tempusdominus-bootstrap-4.min.css', request()->isSecure()) }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    {{-- <link rel="stylesheet"
              href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> --}}

    <title>@yield('title') :: {{ config('app.display_name') }}</title>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed sidebar-collapse text-sm">
    <div class="loading-page">
        <div class="loading-content">
            <img src="{{ asset('img/loader.gif') }}">
            <h4 class="text-center loading-text">Loading...</h4>
        </div>
    </div>

    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            @include('layouts.partials.header')
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            @include('layouts.partials.navbar')
        </aside>

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <h1>@yield('title')</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    @include('layouts.partials.message')
                    @yield('content')
                </div>
            </section>
        </div>

        @include('layouts.partials.footer')
    </div>
    <script src="{{ asset('js/app.js', request()->isSecure()) }}"></script>
    <script src="{{ asset('js/button.js', request()->isSecure()) }}"></script>
    <script>
        function leaveChange() {
            if (document.getElementById("leave").value != "1") {
                document.getElementById("message").innerHTML = "Jawaban";
            } else {
                document.getElementById("message").innerHTML = "Pertanyaan";
            }
        }

    </script>
    <script src="{{ asset('js/tempusdominus-bootstrap-4.min.js', request()->isSecure()) }}"></script>

</body>

</html>
