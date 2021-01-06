@extends('layouts.app_landing')
@section('content')
<!-- Content ============================================= -->
<div class="section">
    <div class="container">

        <div class="heading-block center">
            <h2>Struktur Organisasi</h2>
        </div>

        <div class="row col-mb-50">
            <div class="col-12">
                <img data-animate="fadeIn" class="aligncenter" src="{{ asset('profil/'.$v->image) }}" alt="Struktur Organisasi" style="width: 50%; height: 90%;">
            </div>

            <div class="col-md-12">
                <div class="feature-box fbox-plain">
                    <div class="fbox-content">
                        <h3>{{ $v->title }}</h3>
                        <p>{{ $v->description }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- #content end -->
@endsection