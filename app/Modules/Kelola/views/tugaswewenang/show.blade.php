@php
$segment = request()->segment(2);
$title = 'create'; $method = 'post'; $action = 'kelola-tugaswewenang.store';
if ($segment !== 'create' ) { $title = 'show'; $method = 'put'; $action = ['kelola-tugaswewenang.update', $kelola_tugaswewenang->id]; }
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' Kelola - Tugas dan Wewenang')
@section('content')
{{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off', 'files' => true]) }}
<div class="card card-success">
    <div class="card-body">
        {{ Form::fgText('Title', 'title', $kelola_tugaswewenang->title, ['class' => 'form-control', 'disabled'], null, 'text', 'true') }}
        {{ Form::fgText('Description', 'description', $kelola_tugaswewenang->description, ['class' => 'form-control', 'cols' => '20', 'rows' => '5', 'disabled'], null, 'textarea', true) }}
        {{ Form::fgSelect('Status Data', 'status_data', to_dropdown($status_data), $kelola_tugaswewenang->status_data, ['class' => 'form-control', 'disabled'], null, true) }}
        {{ Form::fgSelect('Status', 'status', to_dropdown($status), $kelola_tugaswewenang->status, ['class' => 'form-control', 'disabled'], null, true) }}
    </div>

    <div class="card-footer clearfix">
        <a href="{{ url()->previous() }}" class="btn btn-danger btn-sm">
            <i class="fa fa-times"></i> {{ __('button.back') }}
        </a>
    </div>
</div>
{{ Form::close() }}
@endsection