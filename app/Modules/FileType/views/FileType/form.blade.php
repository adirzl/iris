@php
$segment = request()->segment(2);
$title = 'create'; $method = 'post'; $action = 'FileType.store';
if ($segment !== 'create' ) { $title = 'edit'; $method = 'put'; $action = ['kelola-banner.update', $kelola_banner->id]; }
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' FileType - Tipe dan Nama')
@section('content')


{{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off']) }}
        <div class="card card-success">
            <div class="card-body">

                {{ Form::fgText('Dokumen Tipe', 'name', $opsi->name, ['class' => 'form-control alphadash lcase'], null, 'text', true) }}

                <div class="form-group row">
                    <label for="" class="col-md-2 col-form-label">Nama</label>
                    <div class="col-md-10">
                            <div class="options" id="options0">
                                <div class="row" style="margin-bottom:8px">
                                    <div class="col-sm-4">
                                        {{ Form::text('keys[]', null, ['class' => 'form-control', 'placeholder' => 'Key Opsi']) }}
                                    </div>

                                    <div class="col-sm-4">
                                        {{ Form::text('values[]', null, ['class' => 'form-control', 'placeholder' => 'Value Opsi']) }}
                                    </div>

                                    <div class="col-sm-4">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-info m-r-5 add" id="add0">
                                            <i class="fa fa-plus"></i>
                                        </a>&nbsp;
                                        <a href="javascript:void(0);" class="btn btn-sm btn-danger rmv" id="rmv0">
                                            <i class="fa fa-minus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>

            <div class="card-footer clearfix">
                {{ Form::fgFormButton('opsi', $segment) }}
            </div>
        </div>
    {{ Form::close() }}

@endsection