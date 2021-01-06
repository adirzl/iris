@extends('layouts.app')
@section('title', __('label.create') . ' Registrasi - Fungsi')
@section('content')
    {{ Form::open(['route' => 'registrasi-aplikasi-fungsi.store', 'method' => 'post', 'class' => 'form-horizontal form-data', 'autocomplete' => 'off']) }}
        <div class="card card-success">
            <div class="card-body">
                {{ Form::fgSelect('Aplikasi', 'reg_aplikasi_id', $aplikasi, null, ['class' => 'form-control select2'], null, true) }}
                <div class="form-group row">
                    <div class="col-md-12">
                        <hr>
                        <div class="row mb-2 fungsi" id="fungsi0">
                            <div class="col-md-6">
                                <label for="">Nama Fungsi</label>
                                {{ Form::text('nama[]', null, ['class' => 'form-control ucase']) }}
                            </div>
                            
                            <div class="col-md-6">
                                <label for="">Menu Fungsi</label>
                                {{ Form::text('menu[]', null, ['class' => 'form-control ucase']) }}
                            </div>

                            <div class="col-md-6 mt-3">
                                <label for="">Fungsi Akses 1</label>
                                {{ Form::select('akses1[]', to_dropdown($akses_aplikasi), null, ['class' => 'form-control']) }}
                                <span id="akses10" class="akses1 d-none">
                                    {{ Form::select('akses1[]', $unitkerja, null, ['class' => 'form-control ukerakses1 select2', 'id' => 'ukerakses10', 'disabled' => true]) }}
                                    <a href="javascript:void(0);" id="batalakses10" class="batalakses1">{{ __('button.cancel') }}</a>
                                </span>
                            </div>

                            <div class="col-md-6 mt-3">
                                <label for="">Fungsi Akses 2</label>
                                {{ Form::select('akses2[]', to_dropdown($akses_aplikasi), null, ['class' => 'form-control']) }}
                                <span id="akses20" class="akses2 d-none">
                                    {{ Form::select('akses2[]', $unitkerja, null, ['class' => 'form-control ukerakses2 select2', 'id' => 'ukerakses20', 'disabled' => true]) }}
                                    <a href="javascript:void(0);" id="batalakses20" class="batalakses2">{{ __('button.cancel') }}</a>
                                </span>
                            </div>

                            <div class="col-md-6 mt-3">
                                <label for="">Limit Debit</label>
                                {{ Form::text('limit_debit[]', null, ['class' => 'form-control currency']) }}
                            </div>

                            <div class="col-md-6 mt-3">
                                <label for="">Limit Kredit</label>
                                {{ Form::text('limit_kredit[]', null, ['class' => 'form-control currency']) }}
                            </div>

                            <div class="col-md-6 mt-3">
                                <label for="">SPV</label>
                                {{ Form::select('spv[]', to_dropdown($char_decision), null, ['class' => 'form-control']) }}
                            </div>

                            <div class="col-md-6 mt-3">
                                <label for="">Status</label>
                                {{ Form::select('status[]', to_dropdown($status), null, ['class' => 'form-control']) }}
                            </div>

                            <div class="col-md-12 mt-3 text-right">
                                <a href="javascript:void(0);" class="btn btn-info add mr-1" id="add0">
                                    <i class="fa fa-plus"></i>
                                </a>
                                <a href="javascript:void(0);" class="btn btn-danger rmv" id="rmv0">
                                    <i class="fa fa-minus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer clearfix">
                {{ Form::fgFormButton('registrasi-aplikasi', request()->segment(2)) }}
            </div>
        </div>
    {{ Form::close() }}
@endsection