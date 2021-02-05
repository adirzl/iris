@extends('layouts.app_landing')
@section('content')

    <section id="page-title">
        <div class="container clearfix">
            {{-- <h1>{{ strtoupper($unitkerja->name) }}</h1> --}}
            <h1>Request Access File</h1>
        </div>
    </section>
    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                <div class="row">
                    <div class="postcontent col-lg-12">
                        {{ Form::open(['route' => 'store.landingrequestfile', 'method' => 'post', 'class' => 'form-horizontal form-data form-group', 'autocomplete' => 'off', 'files' => true]) }}
                        <div class="col-12 form-group">
                            Anda akan request access file : <strong>{{ $data->label }}</strong><br><br>
                            {{ Form::hidden('filearchive_id', $data->id) }}
                            <label>Deskripsi permohonan :</label>
                            {{ Form::textarea('description', null, ['id' => 'feedback-form-more-feedback', 'class' => 'form-control', 'cols' => '2', 'rows' => '5']) }}
                            <br>
                            <button type="submit" class="btn btn-info">Request</button>&nbsp;
                            <a href="{{ url()->previous() }}" class="btn btn-danger">Cancel</button>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- #content end -->
@endsection
