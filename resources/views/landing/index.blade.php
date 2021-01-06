@extends('layouts.app_landing')
@section('content')

<section id="slider" class="slider-element slider-parallax swiper_wrapper vh-75">
    <div class="slider-inner">

        <div class="swiper-container swiper-parent">
            <div class="swiper-wrapper">
                @foreach($data as $v)
                @if($v->status == 1)
                <div class="swiper-slide dark">
                    <div class="swiper-slide-bg" style="background-image: url('banner/{{$v->image}}');"></div>
                </div>
                @endif
                @endforeach
            </div>
            <div class="slider-arrow-left"><i class="icon-angle-left"></i></div>
            <div class="slider-arrow-right"><i class="icon-angle-right"></i></div>
            <div class="slide-number">
                <div class="slide-number-current"></div><span>/</span>
                <div class="slide-number-total"></div>
            </div>
        </div>

    </div>
</section>

<!-- Content
		============================================= -->
<section id="content">
    <div class="content-wrap">

        <div class="promo promo-light promo-full bottommargin-lg header-stick border-top-0 p-5">
            <div class="container clearfix">
                <div class="row align-items-center">
                    <div class="col-12 col-lg">
                        <h3>Integrated Reporting Information System (<span> IRIS</span> )</h3>
                        <span>Merupakan sebuah <em>wadah informasi terpadu</em> yang dibentuk untuk mengintegrasikan <em>laporan keuangan</em> <br>dan <em>tata kelola anggota</em> Konglomerasi Keuangan <em>Bank bjb</em></span>
                    </div>
                    <div class="col-12 col-lg-auto mt-4 mt-lg-0">
                        <a href="{{url(auth()->check() ? 'home' : 'login_iris')}}" target="blank" class="button button-large button-circle m-0">Login</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container clearfix">

            <div class="row col-mb-50">
                <div class="col-sm-6 col-lg-3">
                    <div class="feature-box fbox-center fbox-light fbox-effect border-bottom-0">
                        <div class="fbox-icon">
                            <a href="#"><i class="i-alt border-0 icon-line-monitor"></i></a>
                        </div>
                        <div class="fbox-content">
                            <h3>Monitoring<span class="subtitle">Informasi yang terkelola</span></h3>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="feature-box fbox-center fbox-light fbox-effect border-bottom-0">
                        <div class="fbox-icon">
                            <a href="#"><i class="i-alt border-0 icon-project-diagram"></i></a>
                        </div>
                        <div class="fbox-content">
                            <h3>Integrated Information<span class="subtitle">Informasi yang terintegrasi</span></h3>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="feature-box fbox-center fbox-light fbox-effect border-bottom-0">
                        <div class="fbox-icon">
                            <a href="#"><i class="i-alt border-0 icon-news"></i></a>
                        </div>
                        <div class="fbox-content">
                            <h3>Transparency<span class="subtitle">Transparansi data</span></h3>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="feature-box fbox-center fbox-light fbox-effect border-bottom-0">
                        <div class="fbox-icon">
                            <a href="#"><i class="i-alt border-0 icon-calendar-check"></i></a>
                        </div>
                        <div class="fbox-content">
                            <h3>Monthly Report<span class="subtitle">Laporan setiap bulan</span></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section topmargin-lg">
            <div class="heading-block center">
                <h3>Berita dan Artikel <span>Anak Perusahaan</span></h3>
                <span>Informasi terkini tentang anak perusahaan Bank bjb.</span>
            </div>

            <div id="oc-portfolio" class="owl-carousel portfolio-carousel carousel-widget" data-margin="1" data-pagi="false" data-autoplay="5000" data-items-xs="1" data-items-sm="2" data-items-md="3" data-items-xl="4">
                @foreach($data_artikel as $w)
                <div class="portfolio-item">
                    <div class="portfolio-image">
                        <a href="{{ url('berita_content/'.$w->id) }}">
                            <img src="{{asset('artikel/'.$w->image)}}" alt="Open Imagination">
                        </a>
                        <div class="bg-overlay">
                            <div class="bg-overlay-content dark" data-hover-animate="fadeIn" data-hover-speed="350">
                                <a href="{{asset('artikel/'.$w->image)}}" class="overlay-trigger-icon bg-light text-dark" data-hover-animate="fadeInDownSmall" data-hover-animate-out="fadeInUpSmall" data-hover-speed="350" data-lightbox="image"><i class="icon-line-plus"></i></a>
                                <a href="{{ url('berita_content/'.$w->id) }}" class="overlay-trigger-icon bg-light text-dark" data-hover-animate="fadeInDownSmall" data-hover-animate-out="fadeInUpSmall" data-hover-speed="350"><i class="icon-line-ellipsis"></i></a>
                            </div>
                            <div class="bg-overlay-bg dark" data-hover-animate="fadeIn" data-hover-speed="350"></div>
                        </div>
                    </div>
                    <div class="portfolio-desc">
                        <span>{{ date('d M Y', strtotime($w->created_at)) }}</span>
                        <h3><a href="{{ url('berita_content/'.$w->id) }}">{{$w->title}}</a></h3>
                        <span><a href="#">{{ Str::words($w->description,1) }}</a></span>
                    </div>
                </div>
                @endforeach

            </div>
        </div>

        <div class="container clearfix">

            <div id="oc-clients" class="owl-carousel owl-carousel-full image-carousel carousel-widget" data-margin="30" data-loop="true" data-nav="false" data-autoplay="5000" data-pagi="false" data-items-xs="2" data-items-sm="3" data-items-md="4" data-items-lg="5" data-items-xl="5" style="padding: 20px 0;">

                <div class="oc-item">
                    <a href="#"><img src="{{asset('app-assets/images/logo/1.png')}}" alt="Clients" height="120" width="100"></a>
                </div>
                <div class="oc-item">
                    <a href="#"><img src="{{asset('app-assets/images/logo/2.png')}}" alt="Clients" height="100" width="100"></a>
                </div>
                <div class="oc-item">
                    <a href="#"><img src="{{asset('app-assets/images/logo/3.png')}}" alt="Clients" height="100" width="50"></a>
                </div>
                <div class="oc-item">
                    <h3>BPR Jalan Cagak Subang</h3>
                </div>
                <div class="oc-item">
                    <a href="#"><img src="{{asset('app-assets/images/logo/5.png')}}" alt="Clients" height="100" width="100"></a>
                </div>

            </div>

        </div>

        <a href="{{url(auth()->check() ? 'home' : 'login_iris')}}" target="blank" class="button button-full center text-right footer-stick">
            <div class="container clearfix">
                Laporan keuangan anak perusahaan. <strong>Login</strong> <i class="icon-caret-right" style="top:4px;"></i>
            </div>
        </a>

    </div>
</section>
<!-- #content end -->
@endsection