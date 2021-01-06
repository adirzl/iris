@php
    $segment = request()->segment(2);
    $title = 'create'; $method = 'post'; $action = 'registrasi-server.store';
    if ($segment !== 'create' ) { $title = 'edit'; $method = 'put'; $action = ['registrasi-server.update', $registrasi_server->id]; }
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' Registrasi - Server')
@section('content')
    {{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off']) }}
        <div class="card card-success">
            <div class="card-body">
                {{ Form::fgText('IP Address Aplikasi', 'ip_address', $registrasi_server->ip_address, ['class' => 'form-control ipaddr'], null, 'text', true) }}
                {{ Form::fgText('Nama Aplikasi', 'nama', $registrasi_server->nama, ['class' => 'form-control'], null, 'text', true) }}
                {{ Form::fgSelect('Environment', 'environment', to_dropdown($environment), $registrasi_server->environment, ['class' => 'form-control'], null, true) }}
                {{ Form::fgOption('Blacklist', 'blacklist', $bool_decision, $registrasi_server->blacklist, null, 'radio', true) }}
                {{ Form::fgSelect('Koneksi', 'koneksi', to_dropdown($environment), $registrasi_server->koneksi, ['class' => 'form-control'], null, true) }}
            </div>

            <div class="card-footer clearfix">
                {{ Form::fgFormButton('registrasi-server', $segment) }}
            </div>
        </div>
    {{ Form::close() }}
@endsection