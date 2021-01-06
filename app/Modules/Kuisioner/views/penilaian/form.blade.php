@php
$segment = request()->segment(2);
$title = 'create'; $method = 'post'; $action = 'kuisioner-penilaian.store';
if ($segment !== 'create' ) { $title = 'edit'; $method = 'put'; $action = ['kuisioner-penilaian.update', $kuisioner_penilaian->id]; }
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' Kuisioner - Penilaian')
@section('content')
{{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off', 'files' => true]) }}
<div class="card card-success">
    <div class="card-body">
        {{ Form::fgText('Title', 'title', $kuisioner_penilaian->title, ['class' => 'form-control'], null, 'text', true) }}
        {{ Form::fgText('Description', 'description', $kuisioner_penilaian->description, ['class' => 'form-control', 'cols' => '20', 'rows' => '5'], null, 'textarea', true) }}
    </div>

    <div class="card-footer clearfix">
        {{ Form::fgFormButton('kuisioner-penilaian', $segment) }}
    </div>
</div>
{{ Form::close() }}
@endsection