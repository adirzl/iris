@extends('layouts.app_landing')
@section('content')

<!-- Page Title ============================================= -->
<section id="page-title">

    <div class="container clearfix">
        <h1>{{$data->company_name}}</h1>
    </div>

</section>
<!-- #page-title end -->

<!-- Content ============================================= -->
<section id="content">
    <div class="content-wrap">

        <div class="container">

            <div class="row align-items col-mb-50">
                <div class="col-md-5">
                    <img src="{{ asset('comprof/'.$data->image) }}">
                </div>

                <div class="col-md-7 text-center text-md-left">
                    <p>{{ $data->description }}</p>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- #content end -->
@endsection