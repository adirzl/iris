@php
    $segment = request()->segment(2);
    $title = 'create'; $method = 'post'; $action = 'registrasi-aplikasi.store';
    if ($segment !== 'create' ) { $title = 'edit'; $method = 'put'; $action = ['registrasi-aplikasi.update', $registrasi_aplikasi->id]; }
    unset($akses_aplikasi['UKER']);
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' Registrasi - Aplikasi')
@section('content')
    {{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off']) }}
        <div class="card card-success">
            <div class="card-body">
                {{ Form::fgText('ID Aplikasi', 'idaplikasi', $registrasi_aplikasi->idaplikasi, ['class' => 'form-control number', 'readonly' => true], null, 'text', true) }}
                {{ Form::fgText('Nama Aplikasi', 'nama', $registrasi_aplikasi->nama, ['class' => 'form-control'], null, 'text', true) }}
                {{ Form::fgText('Keterangan Aplikasi', 'keterangan', $registrasi_aplikasi->keterangan, ['class' => 'form-control'], null, 'text', true) }}
                {{ Form::fgText('Alamat Aplikasi', 'alamat', $registrasi_aplikasi->alamat, ['class' => 'form-control'], null, 'text', true) }}
                {{ Form::fgOption('Ada Limit Aplikasi', 'ada_limit', $char_decision, $registrasi_aplikasi->ada_limit, null, 'radio', true) }}
                {{ Form::fgSelect('Akses Aplikasi', 'akses', to_dropdown($akses_aplikasi), $registrasi_aplikasi->akses, ['class' => 'form-control'], null, true) }}
                {{ Form::fgOption('Muncul di UIM', 'muncul_di_uim', $char_decision, $registrasi_aplikasi->muncul_di_uim, null, 'radio', true) }}
                {{ Form::fgSelect('Otentikasi User', 'otentikasi_user', to_dropdown($otentikasi_user), $registrasi_aplikasi->otentikasi_user, ['class' => 'form-control'], null, true) }}
            </div>

            <div class="card-footer clearfix">
                {{ Form::fgFormButton('registrasi-aplikasi', $segment) }}
            </div>
        </div>
    {{ Form::close() }}
@endsection