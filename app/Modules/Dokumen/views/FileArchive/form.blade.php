@php
$segment = request()->segment(2);
$title = 'create'; $method = 'post'; $action = 'dokumen-filearchive.store';

if ($segment !== 'create' ) { $title = 'revisi';  }
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' Dokumen Upload')
@section('content')


{{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off', 'files' => true]) }}
        <div class="card card-success">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                    {{ Form::fgSelect('Unit Kerja', 'unitkerja_kode',$unitkerja, $d->unitkerja_kode, ['id'=>'unitkerja_kode','class' => 'form-control unitkerja_kode_upload'], null, 'text', true) }}
                    {{ Form::fgSelect('Tipe', 'filetype_id',$filetype, null, ['id'=>'filetype','class' => 'form-control filetype_version'], null, 'text', true) }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <b>Upload File</b>
                    </div>
                    <div class="col-md-3">
                        {!! Form::file('path', ['class' => 'form-control dropify']) !!}
                        <br> 
                    </div>       
                </div>
                <div class="row">
                    <div class="col-md-12">
                    {{ Form::fgText('Versi', 'version',$d->version, ['id'=>'version','class' => 'form-control','readonly'], null, 'text', true) }}
                    {{ Form::fgSelect('Tipe Dokumen', 'tipe_dokumen',$tipe_dokumen, $d->tipe_dokumen, ['id'=>'filetype','class' => 'form-control'], null, 'text', true) }}
                    {{ Form::fgSelect('Status', 'status',$status, $d->status, ['id'=>'filetype','class' => 'form-control'], null, 'text', true) }}
                    </div>
                    
                </div>
            </div>

            <div class="card-footer clearfix">
                {{ Form::fgFormButton('opsi', $segment) }}
            </div>
        </div>
    {{ Form::close() }}

@endsection