@php
$segment = request()->segment(2);
$title = 'create'; $method = 'post'; $action = 'kelola-laporan.store';
if ($segment !== 'create' ) { $title = 'edit'; $method = 'put'; $action = ['kelola-laporan.update', $kelola_laporan->id]; }
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' Kelola - Laporan')
@section('content')
{{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off', 'files' => true]) }}
<div class="card card-success">
    <div class="card-body">
        {{ Form::hidden('status_progres', '1') }}
        {{ Form::fgText('Periode Bulan', 'periode', $kelola_laporan->periode, ['class' => 'form-control monthpick', 'placeholder' => 'Bulan'], null, 'text', true) }}
        {{ Form::fgText('Periode Tahun', 'tahun', $kelola_laporan->tahun, ['class' => 'form-control yearpick', 'placeholder' => 'Tahun'], null, 'text', true) }}
        {{ Form::fgSelect('Nama Perusahaan', 'company_name', to_dropdown($company_name), $kelola_laporan->company_name, ['class' => 'form-control'], null, true) }}
        {{ Form::fgText('Title', 'title', $kelola_laporan->title, ['class' => 'form-control'], null, 'text', true) }}
        {{ Form::fgText('Description', 'description', $kelola_laporan->description, ['class' => 'form-control', 'cols' => '20', 'rows' => '5'], null, 'textarea', true) }}
        <div class="form-group row">
            <label for="" class="col-md-2 col-form-label">Upload File</label>
            @isset($kelola_laporan->file)
            <div class="col-md-5 text-left">
                <a href="{{ asset('laporan_files/' . $kelola_laporan->file) }}" alt="file" width="500" height="200" style="margin-top: 0%">{{ $kelola_laporan->file }}</a>
            </div>
            @endisset
            <div class="col-md-{{ isset($kelola_laporan->file) ? '5' : '10'}}">
                {!! Form::file($file, ['class' => 'form-control']) !!}
            </div>
        </div>
        {{ Form::fgSelect('Status', 'status', to_dropdown($status_laporan), $kelola_laporan->status, ['class' => 'form-control'], null, true) }}
    </div>
    <div class="card-footer clearfix">
        {{ Form::fgFormButton('kelola-laporan', $segment) }}
    </div>
</div>
{{ Form::close() }}
@endsection