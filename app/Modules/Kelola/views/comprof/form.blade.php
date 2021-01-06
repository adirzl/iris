@php
$segment = request()->segment(2);
$title = 'create'; $method = 'post'; $action = 'kelola-comprof.store';
if ($segment !== 'create' ) { $title = 'edit'; $method = 'put'; $action = ['kelola-comprof.update', $kelola_comprof->id]; }
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' Kelola - Company Profile')
@section('content')
{{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off', 'files' => true]) }}
<div class="card card-success">
    <div class="card-body">
        {{ Form::fgText('Company Name', 'company_name', $kelola_comprof->company_name, ['class' => 'form-control'], null, 'text', true) }}
        {{ Form::fgText('Description', 'description', $kelola_comprof->description, ['class' => 'form-control', 'cols' => '20', 'rows' => '5'], null, 'textarea', true) }}
        <div class="form-group row">
            <label for="" class="col-md-2 col-form-label">Upload Image</label>
            @isset($kelola_comprof->image)
            <div class="col-md-5 text-left">
                <img src="{{ asset('comprof/' . $kelola_comprof->image) }}" alt="logo" width="500" height="200" style="margin-top: 0%">
            </div>
            @endisset
            <div class="col-md-{{ isset($kelola_comprof->image) ? '5' : '10'}}">
                {!! Form::file($image, ['class' => 'form-control dropify']) !!}
            </div>
        </div>
        {{ Form::fgSelect('Status', 'status', to_dropdown($status_perusahaan), $kelola_comprof->status, ['class' => 'form-control'], null, true) }}
    </div>

    <div class="card-footer clearfix">
        {{ Form::fgFormButton('kelola-comprof', $segment) }}
    </div>
</div>
{{ Form::close() }}
@endsection