@php
$segment = request()->segment(2);
$title = 'create'; $method = 'post'; $action = 'kelola-regulasi.store';
if ($segment !== 'create' ) { $title = 'edit'; $method = 'put'; $action = ['kelola-regulasi.update', $kelola_regulasi->id]; }
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' Kelola - Regulasi')
@section('content')
{{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off', 'files' => true]) }}
<div class="card card-success">
    <div class="card-body">
        {{ Form::fgText('Title', 'title', $kelola_regulasi->title, ['class' => 'form-control'], null, 'text', true) }}
        {{ Form::fgText('Description', 'description', $kelola_regulasi->description, ['class' => 'form-control', 'cols' => '20', 'rows' => '5'], null, 'textarea', true) }}
        <div class="form-group row">
            <label for="" class="col-md-2 col-form-label">Upload Image</label>
            @isset($kelola_regulasi->image)
            <div class="col-md-5 text-left">
                <img src="{{ asset('regulasi_image/' . $kelola_regulasi->image) }}" alt="logo" width="500" height="200" style="margin-top: 0%">
            </div>
            @endisset
            <div class="col-md-{{ isset($kelola_regulasi->image) ? '5' : '10'}}">
                {!! Form::file($image, ['class' => 'form-control dropify']) !!}
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-md-2 col-form-label">Upload File</label>
            @isset($kelola_regulasi->file)
            <div class="col-md-5 text-left">
                <a href="{{ asset('regulasi_files/' . $kelola_regulasi->file) }}" alt="file" width="500" height="200" style="margin-top: 0%" target="_blank">{{ $kelola_regulasi->file }}</a>
            </div>
            @endisset
            <div class="col-md-{{ isset($kelola_regulasi->file) ? '5' : '10'}} custom-file">
                {!! Form::file($file, ['class' => 'form-control']) !!}
            </div>
        </div>
        {{ Form::fgSelect('Status', 'status', to_dropdown($status_regulasi), $kelola_regulasi->status, ['class' => 'form-control'], null, true) }}
    </div>

    <div class="card-footer clearfix">
        {{ Form::fgFormButton('kelola-regulasi', $segment) }}
    </div>
</div>
{{ Form::close() }}
@endsection