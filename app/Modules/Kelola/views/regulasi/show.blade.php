@php
$segment = request()->segment(2);
$title = 'create'; $method = 'post'; $action = 'kelola-regulasi.store';
if ($segment !== 'create' ) { $title = 'show'; $method = 'put'; $action = ['kelola-regulasi.update', $kelola_regulasi->id]; }
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' Kelola - Regulasi')
@section('content')
{{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off', 'files' => true]) }}
<div class="card card-success">
    <div class="card-body">
        {{ Form::fgText('Title', 'title', $kelola_regulasi->title, ['class' => 'form-control', 'disabled'], null, 'text', 'true') }}
        {{ Form::fgText('Description', 'description', $kelola_regulasi->description, ['class' => 'form-control', 'cols' => '20', 'rows' => '5', 'disabled'], null, 'textarea', true) }}
        <div class="form-group row">
            <label for="" class="col-md-2 col-form-label">Upload Image</label>
            @isset($kelola_regulasi->image)
            <div class="col-md-5 text-left">
                <img src="{{ asset('regulasi_image/' . $kelola_regulasi->image) }}" alt="file" width="500" height="200" style="margin-top: 0%" target="_blank">
            </div>
            @endisset
            @if($title == 'create' && $title == 'edit')
            <div class="col-md-{{ isset($kelola_regulasi->file) ? '5' : '10'}}">
                {!! Form::file($file, ['class' => 'form-control', 'disabled']) !!}
            </div>
            @endif
        </div>
        <div class="form-group row">
            <label for="" class="col-md-2 col-form-label">Upload File</label>
            @isset($kelola_regulasi->file)
            <div class="col-md-5 text-left">
                <a href="{{ asset('regulasi_files/' . $kelola_regulasi->file) }}" alt="file" width="500" height="200" style="margin-top: 0%" target="_blank">{{ $kelola_regulasi->file }}</a>
            </div>
            @endisset
            @if($title == 'create' && $title == 'edit')
            <div class="col-md-{{ isset($kelola_regulasi->file) ? '5' : '10'}}">
                {!! Form::file($file, ['class' => 'form-control', 'disabled']) !!}
            </div>
            @endif
        </div>
        {{ Form::fgSelect('Status', 'status', to_dropdown($status_regulasi), $kelola_regulasi->status, ['class' => 'form-control', 'disabled'], null, true) }}
    </div>

    <div class="card-footer clearfix">
        <a href="{{ url()->previous() }}" class="btn btn-danger btn-sm">
            <i class="fa fa-times"></i> {{ __('button.back') }}
        </a>
    </div>
</div>
{{ Form::close() }}
@endsection