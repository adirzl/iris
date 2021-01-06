@extends('layouts.app')
@section('title', __('label.edit') . ' Registrasi - Fungsi')
@section('content')
    {{ Form::open(['route' => ['registrasi-aplikasi-fungsi.update', $registrasi_aplikasi_fungsi->id], 'method' => 'put', 'class' => 'form-horizontal form-data', 'autocomplete' => 'off']) }}
        <div class="card card-success">
            <div class="card-body">
                {{ Form::fgSelect('Aplikasi', 'reg_aplikasi_id', $aplikasi, $registrasi_aplikasi_fungsi->reg_aplikasi_id, ['class' => 'form-control select2'], null, true) }}
                {{ Form::fgText('Nama Fungsi', 'nama', $registrasi_aplikasi_fungsi->nama, ['class' => 'form-control ucase'], null, 'text', true) }}
                {{ Form::fgText('Menu Fungsi', 'menu', $registrasi_aplikasi_fungsi->menu, ['class' => 'form-control'], null, 'text', true) }}
                <div class="form-group row">
                    <label for="" class="col-md-2 control-label">Fungsi Akses 1</label>
                    <div class="col-md-10">
                        {{ Form::select('akses1', to_dropdown($akses_aplikasi), (in_array($registrasi_aplikasi_fungsi->akses1, $akses_aplikasi) ? $registrasi_aplikasi_fungsi->akses1 : 'UKER'), ['class' => 'form-control', 'id' => 'eakses1']) }}
                        <span id="akses1" class="d-none">
                            {{ Form::select('akses1', $unitkerja, $registrasi_aplikasi_fungsi->akses1, ['class' => 'form-control select2', 'id' => 'ukerakses1', 'disabled' => true]) }}
                            <a href="javascript:void(0);" id="batalakses1">{{ __('button.cancel') }}</a>
                        </span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-md-2 control-label">Fungsi Akses 2</label>
                    <div class="col-md-10">
                        {{ Form::select('akses2', to_dropdown($akses_aplikasi), (in_array($registrasi_aplikasi_fungsi->akses2, $akses_aplikasi) ? $registrasi_aplikasi_fungsi->akses2 : 'UKER'), ['class' => 'form-control', 'id' => 'eakses2']) }}
                        <span id="akses2" class="d-none">
                            {{ Form::select('akses2', $unitkerja, $registrasi_aplikasi_fungsi->akses2, ['class' => 'form-control select2', 'id' => 'ukerakses2', 'disabled' => true]) }}
                            <a href="javascript:void(0);" id="batalakses2">{{ __('button.cancel') }}</a>
                        </span>
                    </div>
                </div>
                {{ Form::fgText('Limit Debit', 'limit_debit', number_format($registrasi_aplikasi_fungsi->limit_debit), ['class' => 'form-control currency'], null, 'text', true) }}
                {{ Form::fgText('Limit Kredit', 'limit_kredit', number_format($registrasi_aplikasi_fungsi->limit_kredit), ['class' => 'form-control currency'], null, 'text', true) }}
                {{ Form::fgOption('SPV', 'spv', $char_decision, $registrasi_aplikasi_fungsi->spv, null, 'radio', true) }}
                {{ Form::fgOption('Status', 'status', $status, $registrasi_aplikasi_fungsi->status, null, 'radio', true) }}
            </div>

            <div class="card-footer clearfix">
                {{ Form::fgFormButton('registrasi-aplikasi-fungsi', request()->segment(2)) }}
            </div>
        </div>
    {{ Form::close() }}
@endsection