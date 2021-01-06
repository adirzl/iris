@extends('layouts.app_landing')
@section('content')

<!-- Page Title ============================================= -->
<section id="page-title">

    <div class="container clearfix">
        <h1>Judul Rencana Kerja Tahunan Kepatuhan</h1>
    </div>

</section>
<!-- #page-title end -->

<!-- Content ============================================= -->
<section id="content">
    <div class="content-wrap">

        <div class="container">

            <div class="row align-items-center col-mb-50">
                <div class="col-md-5">
                    <img src="{{ asset('profil/'.$v->image) }}">
                </div>

                <div class="col-md-7 text-center text-md-left">
                    <div class="heading-block border-bottom-0">
                        <h4>{{$v->title}}</h4>
                    </div>
                    <p>{{$v->description}}l</p>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- #content end -->

@endsection