@extends('layouts.app_landing')
@section('content')
<!-- Page Title ============================================= -->
<section id="page-title">

    <div class="container clearfix">
        <h1>Berita</h1>
        <span>Deskripsi singkat judul</span>
    </div>

</section>
<!-- #page-title end -->

<!-- Content ============================================= -->
<section id="content">
    <div class="content-wrap">
        <div class="container clearfix">

            <div class="row">
                <div class="postcontent col-lg-9">

                    @foreach($data as $d)
                    <div class="row">
                        <div class="entry event col-12">
                            <div class="grid-inner row no-gutters p-4">
                                <div class="entry-image col-md-5 mb-md-0">
                                    <a href="{{ url('berita_content') }}">
                                        <img src="{{asset('artikel/'.$d->image)}}" alt="{{ $d->title }}">
                                        <div class="entry-date">{{ $d->created_at->format('d') }}<span>{{ $d->created_at->format('M') }}</span></div>
                                    </a>
                                </div>
                                <div class="col-md-7 pl-md-4">
                                    <div class="entry-title title-sm">
                                        <h2><a href="{{ url('berita_content/'.$d->id) }}">{{ $d->title }}</a></h2>
                                    </div>
                                    <div class="entry-meta">
                                        <ul>
                                            <li><span class="badge badge-warning py-1 px-2">Admin</span></li>
                                            <li><a href="#"><i class="icon-time"></i>{{ $d->created_at->format('H:i') }} WIB</a></li>
                                        </ul>
                                    </div>
                                    <div class="entry-content">
                                        <p>Deskripsi Berita</p>
                                        <a href="{{ url('berita_content/'.$d->id) }}" class="btn btn-danger">Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <!-- Pager
							============================================= -->
                    <div class="d-flex justify-content-between">
                        {{ $data->links() }}
                    </div>
                    <!-- .pager end -->

                </div>

                <div class="sidebar col-lg-3">
                    <div class="sidebar-widgets-wrap">

                        <div class="widget clearfix">

                            <h4>Daftar Berita</h4>
                            @foreach($data as $d)
                            <div class="posts-sm row col-mb-30" id="post-list-sidebar">
                                <div class="entry col-12">
                                    <div class="grid-inner row no-gutters">
                                        <div class="col-auto">
                                            <div class="entry-image">
                                                <a href="{{ url('berita_content/'.$d->id) }}"><img src="{{asset('artikel/'.$d->image)}}" alt="Image"></a>
                                            </div>
                                        </div>
                                        <div class="col pl-3">
                                            <div class="entry-title">
                                                <h4><a href="{{ url('berita_content/'.$d->id) }}">{{$d->title}}</a></h4>
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