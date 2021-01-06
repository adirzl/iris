@extends('layouts.app_landing')
@section('content')

<!-- Page Title ============================================= -->
<section id="page-title">

    <div class="container clearfix">
        <h1>Company Profile LJK Dalam Konglomerasi Keuangan</h1>
    </div>

</section>
<!-- #page-title end -->

<!-- Content ============================================= -->
<section id="content">
    <div class="content-wrap">
        <div class="container clearfix">

            <div id="portfolio" class="portfolio row grid-container gutter-20" data-layout="fitRows">
                @foreach($data as $v)
                <article class="portfolio-item col-lg-3 col-md-4 col-sm-6 col-12 pf-media pf-icons">
                    <!-- Grid Inner: Start -->
                    <div class="grid-inner">
                        <!-- Image: Start -->
                        <div class="portfolio-image">
                            <a href="portfolio-single.html">
                                <img src="{{ asset('comprof/'.$v->image) }}" alt="Logo Perusahaan" height="100" width="100">
                            </a>
                            <!-- Overlay: Start -->
                            <div class="bg-overlay">
                                <div class="bg-overlay-content dark" data-hover-animate="fadeIn">
                                    <a href="{{ asset('comprof/'.$v->image) }}" class="overlay-trigger-icon bg-light text-dark" data-hover-animate="fadeInDownSmall" data-hover-animate-out="fadeOutUpSmall" data-hover-speed="350" data-lightbox="image" title="Image"><i class="icon-line-plus"></i></a>
                                    <a href="{{ url('comp_prof_kk_detail/'.$v->id) }}" class="overlay-trigger-icon bg-light text-dark" data-hover-animate="fadeInDownSmall" data-hover-animate-out="fadeOutUpSmall" data-hover-speed="350"><i class="icon-line-ellipsis"></i></a>
                                </div>
                                <div class="bg-overlay-bg dark" data-hover-animate="fadeIn"></div>
                            </div>
                            <!-- Overlay: End -->
                        </div>
                        <!-- Image: End -->
                        <!-- Decription: Start -->
                        <div class="toggle">
                            <div class="toggle-header">
                                <div class="toggle-icon">
                                    <i class="toggle-closed icon-line-plus"></i>
                                    <i class="toggle-open icon-line-minus"></i>
                                </div>
                                <div class="toggle-title">
                                    {{ $v->company_name }}
                                </div>
                            </div>
                            <div class="toggle-content">{{ $v->description }}</div>
                        </div>
                        <!-- Description: End -->
                    </div>
                    <!-- Grid Inner: End -->
                </article>
                @endforeach
            </div>

        </div>
    </div>
</section>
<!-- #content end -->
@endsection