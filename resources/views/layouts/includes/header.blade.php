<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="SemiColonWeb" />

    <!-- Stylesheets
	============================================= -->
    <link rel="stylesheet" href="{{asset('app-assets/css/font-latos.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('app-assets/css/bootstrap.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('app-assets/style.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('app-assets/css/swiper.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('app-assets/css/dark.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('app-assets/css/font-icons.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('app-assets/css/animate.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('app-assets/css/magnific-popup.css')}}" type="text/css" />

    <!-- Bootstrap Data Table Plugin -->
    <link rel="stylesheet" href="{{asset('app-assets/css/components/bs-datatable.css')}}" type="text/css" />

    <link rel="stylesheet" href="{{asset('app-assets/css/custom.css')}}" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Document Title
	============================================= -->
    <title>Beranda :: bjb IRIS</title>

</head>

<body class="stretched">

    <!-- Document Wrapper
	============================================= -->
    <div id="wrapper" class="clearfix">

        <!-- Header
		============================================= -->
        <header id="header" class="full-header">
            <div id="header-wrap">
                <div class="container">
                    <div class="header-row">

                        <!-- Logo
						============================================= -->
                        <div id="logo">
                            <a href="index.html" class="standard-logo"><img src="{{asset('app-assets/images/logo-bjb-2.png')}}" alt="Bank bjb" style="height: 75px;"></a>
                            <a href="index.html" class="retina-logo"><img src="{{asset('app-assets/images/logo-bjb-2.png')}}" alt="Bank bjb" style="height: 75px;"></a>
                        </div>
                        <!-- #logo end -->

                        <div class="header-misc">

                            <!-- Top Search
							============================================= -->
                            <div id="top-search" class="header-misc-icon">
                                <a href="#" id="top-search-trigger"><i class="icon-line-search"></i><i class="icon-line-cross"></i></a>
                            </div>
                            <!-- #top-search end -->

                            <!-- Top Cart
							============================================= -->
                            <!-- <a href="{{url(auth()->check() ? 'home' : 'login_iris')}}" target="blank" id="top-cart-trigger"><i class="icon-door-open"></i></a> -->
                            <!-- #top-cart end -->

                            <!-- Small modal -->
                            <button class="button button-mini button-circle" data-toggle="modal" data-target=".bs-example-modal-sm"><i class="icon-door-open"></i> Login</button>

                        </div>

                        <div id="primary-menu-trigger">
                            <svg class="svg-trigger" viewBox="0 0 100 100">
                                <path d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20"></path>
                                <path d="m 30,50 h 40"></path>
                                <path d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20"></path>
                            </svg>
                        </div>

                        <!-- Primary Navigation
						============================================= -->
                        <nav class="primary-menu">

                            <ul class="menu-container">
                                <li class="menu-item">
                                    <a class="menu-link" href="{{ url('landing') }}">
                                        <div>Beranda</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a class="menu-link" href="{{ route('landingdetail', [ 'id' => env('UK_RISET_ID') ]) }}">
                                        <div>Riset</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a class="menu-link" href="#">
                                        <div>Konglomerasi Keuangan</div>
                                    </a>
                                    <ul class="sub-menu-container">
                                        <li class="menu-item">
                                            <a class="menu-link" href="{{ url('tentang_kk') }}">
                                                <div><i class="icon-stack"></i>Profil Konglomerasi Keuangan</div>
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a class="menu-link" href="{{ url('sekilas_kk') }}">
                                                <div><i class="icon-stack"></i>Sekilas Konglomerasi Keuangan</div>
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a class="menu-link" href="{{ url('struktur_kk') }}">
                                                <div><i class="icon-stack"></i>Struktur Konglomerasi Bank bjb</div>
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a class="menu-link" href="{{ url('comp_prof_kk') }}">
                                                <div><i class="icon-stack"></i>Company Profile LJK Dalam Konglomerasi Keuangan</div>
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a class="menu-link" href="{{ url('tugas_wew_kk') }}">
                                                <div><i class="icon-stack"></i>Tugas dan Kewenangan Entitas Utama</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item">
                                    <a class="menu-link" href="#">
                                        <div>Kinerja Keuangan</div>
                                    </a>
                                    <ul class="sub-menu-container">
                                        <li class="menu-item">
                                            <a class="menu-link" href="{{ url('tentang_kinke') }}">
                                                <div><i class="icon-stack"></i>Tentang Kinerja Keuangan</div>
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a class="menu-link" href="{{ url('report_sumber') }}">
                                                <div><i class="icon-stack"></i>Report Penginputan Sumber Data</div>
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a class="menu-link" href="{{ url('kajian_kinke') }}">
                                                <div><i class="icon-stack"></i>Kajian Kinerja Keuangan</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item">
                                    <a class="menu-link" href="{{ url('regulasi') }}">
                                        <div>Regulasi</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a class="menu-link" href="{{ url('berita') }}">
                                        <div>Berita</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a class="menu-link" href="#">
                                        <div>Penerapan Tatakelola Terintegrasi</div>
                                    </a>
                                    <ul class="sub-menu-container">
                                        <li class="menu-item">
                                            <a class="menu-link" href="{{ url('tentang_tatakelola') }}">
                                                <div><i class="icon-stack"></i>Tata Kelola Terintegrasi</div>
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a class="menu-link" href="#">
                                                <div><i class="icon-stack"></i>Fungsi Pengawasan Manajemen Risiko</div>
                                            </a>
                                            <ul class="sub-menu-container">
                                                <li class="menu-item">
                                                    <a class="menu-link" href="{{ url('tentang_manrisk') }}">
                                                        <div>Tentang Manajemen Risiko Terintegrasi</div>
                                                    </a>
                                                </li>
                                                <li class="menu-item">
                                                    <a class="menu-link" href="{{ url('rencana_kerja_manrisk') }}">
                                                        <div>Rencana Kerja Tahunan Manrisk Terintegrasi</div>
                                                    </a>
                                                </li>
                                                <li class="menu-item">
                                                    <a class="menu-link" href="{{ url('report_kuisioner_manrisk') }}">
                                                        <div>Laporan Pengisian Kuisioner Manajemen Risiko LJK</div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="menu-item">
                                            <a class="menu-link" href="#">
                                                <div><i class="icon-stack"></i>Fungsi Pengawasan Kepatuhan dan APU-PPT</div>
                                            </a>
                                            <ul class="sub-menu-container">
                                                <li class="menu-item">
                                                    <a class="menu-link" href="{{ url('tentang_kepatuhan') }}">
                                                        <div>Tentang Pengawasan Kepatuhan dan APU-PPT</div>
                                                    </a>
                                                </li>
                                                <li class="menu-item">
                                                    <a class="menu-link" href="{{ url('rencana_kerja_kepatuhan') }}">
                                                        <div>Rencana Kerja Tahunan Kepatuhan</div>
                                                    </a>
                                                </li>
                                                <li class="menu-item">
                                                    <a class="menu-link" href="{{ url('report_kuisioner_kepatuhan') }}">
                                                        <div>Laporan Pengisian Kuisioner Kepatuhan</div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="menu-item">
                                            <a class="menu-link" href="#">
                                                <div><i class="icon-stack"></i>Fungsi Pengawasan Audit Internal</div>
                                            </a>
                                            <ul class="sub-menu-container">
                                                <li class="menu-item">
                                                    <a class="menu-link" href="{{ url('tentang_audit') }}">
                                                        <div>Tentang Pengawasan Audit Internal</div>
                                                    </a>
                                                </li>
                                                <li class="menu-item">
                                                    <a class="menu-link" href="{{ url('rencana_kerja_audit') }}">
                                                        <div>Rencana Kerja Audit Tahunan</div>
                                                    </a>
                                                </li>
                                                <li class="menu-item">
                                                    <a class="menu-link" href="{{ url('report_kuisioner_audit') }}">
                                                        <div>Laporan Pengisian Kuisioner Audit Internal</div>
                                                    </a>
                                                </li>
                                                <li class="menu-item">
                                                    <a class="menu-link" href="#">
                                                        <div>Laporan Hasil Monitoring dan Tindak Lanjut</div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="menu-item">
                                            <a class="menu-link" href="#">
                                                <div><i class="icon-stack"></i>Pelaporan Tata Kelola</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>

                        </nav>
                        <!-- #primary-menu end -->

                        <form class="top-search-form" action="search.html" method="get">
                            <input type="text" name="q" class="form-control" value="" placeholder="Ketik &amp; Tekan Enter.." autocomplete="off">
                        </form>

                    </div>
                </div>
            </div>
            <div class="header-wrap-clone"></div>
        </header>
        <!-- #header end -->

        <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-body">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Login Sebagai</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <p class="mb-0">
                                <button class="button button-small button-circle button-border button-fill button-blue" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="icon-user"></i><span>User LJK</span></button>
                                <a href="{{url(auth()->check() ? 'home' : 'login_iris')}}" target="blank" class="button button-small button-circle button-border button-fill button-green"><i class="icon-user"></i><span>User Internal</span></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-body">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #2d91cd;">
                            <h4 class="modal-title" id="myModalLabel" style="color: #fff;">Login User LJK</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="card mx-auto rounded-0 border-0" style="max-width: 400px; background-color: rgba(255,255,255,0.93);">
                                <div class="card-body" style="padding: 40px;">
                                    <form id="login-form" name="login-form" class="mb-0" action="{{ url('ceklogin') }}" method="POST">
                                        @csrf
                                        <h3>Login to your Account</h3>

                                        <div class="row">
                                            <div class="col-12 form-group">
                                                <label for="login-form-username">Username:</label>
                                                <input type="text" id="login-form-username" name="username" value="" class="form-control not-dark" />
                                            </div>

                                            <div class="col-12 form-group">
                                                <label for="login-form-password">Password:</label>
                                                <input type="password" id="login-form-password" name="password" value="" class="form-control not-dark" />
                                            </div>

                                            <div class="col-12 form-group">
                                                <button class="button button-small button-circle button-border button-fill button-green m-0" id="login-form-submit" name="login-form-submit" value="login"><span>Login</span></button>
                                                <a href="#" class="float-right">Forgot Password?</a>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="line line-sm"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
