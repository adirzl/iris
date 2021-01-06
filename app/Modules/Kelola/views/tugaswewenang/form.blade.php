@php
$segment = request()->segment(2);
$title = 'create'; $method = 'post'; $action = 'kelola-tugaswewenang.store';
if ($segment !== 'create' ) { $title = 'edit'; $method = 'put'; $action = ['kelola-tugaswewenang.update', $kelola_tugaswewenang->id]; }
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' Kelola - Tugas dan Wewenang')
@section('content')
{{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off', 'files' => true]) }}
<div class="card card-success">
    <div class="card-body">
        {{ Form::fgSelect('Status Data', 'status_data', to_dropdown($status_data), $kelola_tugaswewenang->status_data, ['class' => 'form-control'], null, true) }}
        {{ Form::fgText('Title', 'title', $kelola_tugaswewenang->title, ['class' => 'form-control'], null, 'text', true) }}
        {{ Form::fgText('Description', 'description', $kelola_tugaswewenang->description, ['class' => 'form-control', 'cols' => '20', 'rows' => '5'], null, 'textarea', true) }}
        {{ Form::fgSelect('Status', 'status', to_dropdown($status), $kelola_tugaswewenang->status, ['class' => 'form-control'], null, true) }}
    </div>

    <div class="card-footer clearfix">
        {{ Form::fgFormButton('kelola-tugaswewenang', $segment) }}
    </div>
</div>
{{ Form::close() }}
@endsection