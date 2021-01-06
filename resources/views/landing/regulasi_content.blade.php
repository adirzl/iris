@extends('layouts.app_landing')
@section('content')

<!-- Page Title ============================================= -->
<section id="page-title">

    <div class="container clearfix">
        <h1>{{ $data->title }}</h1>
    </div>

</section>
<!-- #page-title end -->

<!-- Content ============================================= -->
<section id="content">
    <div class="content-wrap">
        <div class="container clearfix">

            <div class="row gutter-40 col-mb-80">
                <div class="postcontent col-lg-9">
                    <div class="single-event">

                        <div class="row col-mb-50">
                            <div class="col-md-7 col-lg-8">
                                <div class="entry-image mb-0">
                                    <a href="#"><img src="{{asset('regulasi_image/'.$data->image)}}" alt="Berita Image"></a>
                                </div>
                            </div>

                            <div class="col-md-5 col-lg-4">
                                <div class="card event-meta mb-3">
                                    <div class="card-header">
                                        <h5 class="mb-0">File Info:</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="iconlist mb-0">
                                            <li><i class="icon-file"></i> {{ $data->file }}</li>
                                            <li><i class="icon-calendar3"></i> {{ $data->created_at->format('d M Y') }}</li>
                                            <li><i class="icon-time"></i> {{ $data->created_at->format('H:i') }} WIB</li>
                                        </ul>
                                    </div>
                                </div>
                                <a href="{{ asset('regulasi_files/'.$data->file) }}" target="blank" class="btn btn-success btn-block btn-lg">Download</a>
                            </div>

                            <div class="w-100"></div>

                            <div class="col-md-8 col-lg-9">
                                <h3>Detail</h3>

                                <p>{{ $data->description }}</p>

                            </div>
                        </div>

                    </div>
                </div>

                <div class="sidebar col-lg-3">
                    <div class="sidebar-widgets-wrap">

                        <div class="widget clearfix">

                            <h4>Daftar Regulasi</h4>
                            @foreach($data_regulasi as $d)
                            <div class="posts-sm row col-mb-30" id="post-list-sidebar">
                                <div class="entry col-12">
                                    <div class="grid-inner row no-gutters">
                                        <div class="col-auto">
                                            <div class="entry-image">
                                                <a href="{{ url('regulasi_content') }}"><img src="{{asset('regulasi_image/'.$d->image)}}" alt="Image"></a>
                                            </div>
                                        </div>
                                        <div class="col pl-3">
                                            <div class="entry-title">
                                                <h4><a href="{{ url('regulasi_content') }}">{{$d->title}}</a></h4>
                                            </div>
                                            <div class="entry-meta">
                                                <ul>
                                                    <li>{{ $d->created_at->format('d M Y') }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- #content end -->

@endsection