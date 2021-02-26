@extends('layouts.app_landing')
@section('content')

    <section id="slider" class="slider-element slider-parallax swiper_wrapper vh-75" data-margin="1" data-pagi="false"
        data-autoplay="5000" data-items-xs="1" data-items-sm="2" data-items-md="3" data-items-xl="4">
        <div class="slider-inner">

            <div class="swiper-container swiper-parent">
                <div class="swiper-wrapper">
                    @foreach ($data as $v)
                        @if ($v->status == 1)
                            <div class="swiper-slide dark">
                                <div class="container">
                                    <div class="slider-caption slider-caption-left">
                                        <h2 data-animate="fadeInUp">{{ $v->title }}</h2>
                                        <p class="d-none d-sm-block" data-animate="fadeInUp" data-delay="200">
                                            {{ $v->description }}
                                        </p>
                                    </div>
                                </div>
                                <div class="swiper-slide-bg" style="background-image: url('banner/{{ $v->image }}');">
                                </div>
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

    <!-- Content ============================================= -->
    <section id="content">
        <div class="content-wrap">

            <div class="promo promo-light promo-full bottommargin-lg header-stick border-top-0 p-5">
                <div class="container clearfix">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg">
                            <h3>Documents Management Application (<span> DMA</span> )</h3>
                            <span>Merupakan sebuah <em>wadah peng arsipan dokumen</em> yang dibentuk untuk mengintegrasikan
                                <em>seluruh dokumentasi</em> <br>dan <em>tata kelola dokumen</em> di lingkungan
                                <em>Bank bjb</em></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container clearfix">

                <div id="section-specs" class="heading-block text-center page-section">
                    <h2>Divisi Perencanaan</h2>
                    <span>Sekilas tentang Divisi Perencanaan</span>
                </div>

                <div id="side-navigation" class="row" data-plugin="tabs">

                    <div class="col-md-4">

                        <ul class="sidenav">
                            <li><a href="#snav-content1"><i class="icon-screen"></i>Profil<i
                                        class="icon-chevron-right"></i></a></li>
                            <li><a href="#snav-content2"><i class="icon-rocket"></i>Visi dan Misi<i
                                        class="icon-chevron-right"></i></a></li>
                            <li><a href="#snav-content3"><i class="icon-user"></i>Sekapur Sirih Pimpinan Divisi<i
                                        class="icon-chevron-right"></i></a></li>
                        </ul>

                    </div>

                    <div class="col-md-8">
                        <div id="snav-content1">
                            <h3>{{ isset($profil[0]->title) ? $profil[0]->title : '' }}</h3>
                            @if (isset($profil[0]->image))
                                <img class="alignright img-responsive"
                                    src="http://127.0.0.1:8080/konten/{{ $profil[0]->image }}" width="30%" height="30%"
                                    alt="Image">
                            @endif
                            {{ isset($profil[0]->description) ? $profil[0]->description : '' }}
                        </div>

                        <div id="snav-content2">
                            <h3>{{ isset($profil[1]->title) ? $profil[1]->title : '' }}</h3>
                            {{ isset($profil[1]->description) ? $profil[1]->description : '' }}
                        </div>

                        <div id="snav-content3">
                            @if (isset($profil[2]->title))
                                <img class="alignleft img-responsive"
                                    src="http://127.0.0.1:8080/konten/{{ $profil[2]->image }}" alt="Image">
                            @endif
                            <h3>{{ isset($profil[2]->title) ? $profil[2]->title : '' }}</h3>
                            {{ isset($profil[2]->description) ? $profil[2]->description : '' }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section id="page-title">
        <div class="container clearfix">
            <h1>Arsip Dokumen</h1>
            <span>Deskripsi singkat judul</span>
        </div>
    </section>
    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                <div class="row">
                    <div class="postcontent col-lg-9">
                        <ul>
                            <div class="table-responsive">
                                {{ Form::hidden('unitkerja_kode', env('D_PERENCANAAN_ID'), ['id' => 'unitkerja_kode']) }}
                                <table class="table table-bordered table-striped mb-0" id="table-file">
                                    <thead>
                                        <tr>
                                            <th>Actions</th>
                                            <th>Nama Dokumen</th>
                                            <th>Type</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($fileArchive as $item)
                                            <tr>
                                                <td>
                                                    @if ($item->tipe_dokumen == 2 || ($item->last_requestfile->count() > 0 ? ($item->last_requestfile->first()->status == 2 ? true : false) : false))
                                                        
                                                        @if($item->fileext == 'pdf')
                                                        <a href="{{ url('landingdownload',$item->id) }}"
                                                            class="btn btn-success" target="_blank">Open</a>
                                                        @else
                                                        <a href="{{ asset('storage/dokumen/' . $item->unitkerja_kode . '/' . $item->filetype_id . '/' . $item->filename) }}"
                                                            class="btn btn-success" target="_blank">Open</a>
                                                        @endif
                                                    @else
                                                        @if (Auth::check())
                                                            <a href="{{ route('landingrequestfile', ['id' => $item->id]) }}"
                                                                class="btn btn-warning">Request</a>
                                                        @else
                                                            <input type="hidden" name="filearchive" id="filearchive"
                                                                value="{{ $item->id }}">
                                                            <button data-toggle="modal" class="btn btn-warning"
                                                                data-target=".bs-example-modal-lg"
                                                                id="request">Request</button>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>{{ $item->label }}</td>
                                                <td>{{ $item->file_type->name }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td>
                                                    <span class="badge bg-success"
                                                        style="color: white">{{ $tipe_dokumen[$item->tipe_dokumen] }}</span>&nbsp;
                                                    <span class="badge bg-info"
                                                        style="color: white">{{ $item->fileext }}</span>
                                                    @if ($item->tipe_dokumen == 1)
                                                        <span class="badge bg-danger"
                                                            style="color: white">{{ isset($status_requestfile[isset($item->last_requestfile->first()->status)]) ? $status_requestfile[$item->last_requestfile->first()->status] : '' }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </ul>
                    </div>

                    <div class="sidebar col-lg-3">
                        <div class="sidebar-widgets-wrap">
                            <div class="widget clearfix">
                                {{ Form::text('keyword', null, ['class' => 'form-control', 'id' => 'keyword', 'placeholder' => 'Pencarian']) }}
                                <br>
                                <div style="margin-top: 10%">
                                    <label>File Type</label>
                                    @foreach ($fileType as $item)
                                        <li>{{ Form::checkbox('fileType_id[]', $item->id, null, ['class' => 'f_filetype']) }}
                                            {{ $item->name }}</li>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- #content end -->
@endsection
