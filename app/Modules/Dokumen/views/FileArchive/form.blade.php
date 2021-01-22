@php
$segment = request()->segment(2);
$title = 'create'; $method = 'post'; $action = 'dokumen-filearchive.store';
if ($segment !== 'create' ) { $title = 'edit'; $method = 'put'; $action = ['kelola-banner.update', $kelola_banner->id]; }
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' FileType - Tipe dan Nama')
@section('content')


{{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off']) }}
        <div class="card card-success">
            <div class="card-body">
            {{ Form::fgSelect('Unit Kerja', 'unitkerja_kode',$unitkerja, $d->unitkerja_kode, ['id'=>'unitkerja_kode','class' => 'form-control unitkerja_kode_upload'], null, 'text', true) }}
            {{ Form::fgSelect('Tipe', 'filetype',[''=>'-Pilih Satu-'], null, ['id'=>'filetype','class' => 'form-control'], null, 'text', true) }}
            
            </div>

            <div class="card-footer clearfix">
                {{ Form::fgFormButton('opsi', $segment) }}
            </div>
        </div>
    {{ Form::close() }}

@endsection