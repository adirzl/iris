@extends('layouts.app_landing')
@section('content')

    @if ($unitkerja)
        <section id="page-title">
            <div class="container clearfix">
                <h1>{{ strtoupper($unitkerja->name) }}</h1>
                <span>Deskripsi singkat judul</span>
            </div>
        </section>
        <section id="content">
            <div class="content-wrap">
                <div class="container clearfix">

                    <div class="row">
                        <div class="postcontent col-lg-9">
                            THIS IS MAIN CONTENT
                            <ul>
                                @foreach ($data as $item)
                                    <li>{{ $item->name }}</li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="sidebar col-lg-3">
                            <div class="sidebar-widgets-wrap">
                                <div class="widget clearfix">
                                    {{ Form::text('keyword', null, ['class' => 'asdf', 'id' => 'keyword']) }}
                                    <button>Cari</button>
                                    <h4>File Type</h4>
                                    @foreach ($fileType as $item)
                                        <ul>
                                            <li>{{ Form::checkbox('fileType[]', true, null) }} {{ $item->name }}</li>
                                        </ul>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    @endif
@endsection
