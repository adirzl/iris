@php
$segment = request()->segment(2);
$title = 'create'; $method = 'post'; $action = 'kelola-profilkonglomerasi.store';
if ($segment !== 'create' ) { $title = 'edit'; $method = 'put'; $action = ['kelola-profilkonglomerasi.update', $kelola_profilkonglomerasi->id]; }
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' Kelola - Profil Konglomerasi')
@section('content')
{{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off', 'files' => true]) }}
<div class="card card-success">
    <div class="card-body">
        {{ Form::fgText('Title', 'title', $kelola_profilkonglomerasi->title, ['class' => 'form-control'], null, 'text', true) }}
        {{ Form::fgText('Description', 'description', $kelola_profilkonglomerasi->description, ['class' => 'form-control', 'cols' => '20', 'rows' => '5'], null, 'textarea', true) }}
        <div class="form-group row">
            <label for="" class="col-md-2 col-form-label">Upload Image</label>
            @isset($kelola_profilkonglomerasi->image)
            <div class="col-md-5 text-center">
                <img src="{{ asset('profil/' . $kelola_profilkonglomerasi->image) }}" alt="logo" width="500" height="200" style="margin-top: 0%">
            </div>
            @endisset
            <div class="col-md-{{ isset($kelola_profilkonglomerasi->image) ? '5' : '10'}}">
                {!! Form::file($image, ['class' => 'form-control dropify']) !!}
            </div>
        </div>
        @if($title == 'create')
        {{ Form::fgSelect('Status', 'status', to_dropdown($status_profil), $kelola_profilkonglomerasi->status, ['class' => 'form-control'], null, true) }}
        @endif
    </div>

    <div class="card-footer clearfix">
        {{ Form::fgFormButton('kelola-profilkonglomerasi', $segment) }}
    </div>
</div>
{{ Form::close() }}
@endsection