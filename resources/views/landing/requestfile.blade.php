@extends('layouts.app_landing')
@section('content')

    <section id="page-title">
        <div class="container clearfix">
            {{-- <h1>{{ strtoupper($unitkerja->name) }}</h1> --}}
            <h1>Request Access File</h1>
            <span>Deskripsi singkat judul</span>
        </div>
    </section>
    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                <div class="row">
                    <div class="postcontent col-lg-12">
                        {{ Form::open(['route' => 'store.landingrequestfile', 'method' => 'post', 'class' => 'form-horizontal form-data', 'autocomplete' => 'off', 'files' => true]) }}
                            anda akan request access file {{ $data->label }}<br />
                            <div class="col-md-12">
                                {{ Form::hidden('filearchive_id', $data->id) }}
                                <label>Deskripsi permohonan :</label>
                                {{ Form::textarea('description', null) }}
                                <button type="submit" class="btn btn-info">Save</button>
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- #content end -->
@endsection
