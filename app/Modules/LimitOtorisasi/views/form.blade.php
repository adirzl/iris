@php
    $segment = request()->segment(2);
    $title = 'create'; $method = 'post'; $action = 'limit-otorisasi.store';
    if ($segment !== 'create' ) { $title = 'edit'; $method = 'put'; $action = ['limit-otorisasi.update', $limit_otorisasi->id]; }
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' Limit Otorisasi')
@section('content')
    {{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off']) }}
        <div class="card card-success">
            <div class="card-body">
                {{ Form::fgText('Grup Limit', 'kode', $limit_otorisasi->kode, ['class' => 'form-control ucase'], null, 'text', true) }}

                <div class="form-group row">
                    <label for="" class="col-md-2 col-form-label">Jabatan</label>
                    <div class="col-md-10">
                        @isset($limit_otorisasi->jabatan)
                            @foreach($limit_otorisasi->jabatan as $j)
                                <div class="jabatan" id="jabatan{{ $loop->iteration }}">
                                    <div class="row mb-2">
                                        <div class="col-sm-8">
                                            {{ Form::select('jabatan[]', $jabatan, $j, ['class' => 'form-control']) }}
                                        </div>

                                        <div class="col-sm-4">
                                            <a href="javascript:void(0);" class="btn btn-sm btn-info m-r-5 add" id="add{{ $loop->iteration }}">
                                                <i class="fa fa-plus"></i>
                                            </a>&nbsp;
                                            <a href="javascript:void(0);" class="btn btn-sm btn-danger rmv" id="rmv{{ $loop->iteration }}">
                                                <i class="fa fa-minus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="jabatan" id="jabatan0">
                                <div class="row mb-2">
                                    <div class="col-sm-8">
                                        {{ Form::select('jabatan[]', $jabatan, null, ['class' => 'form-control']) }}
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
                        @endisset
                    </div>
                </div>

                {{ Form::fgText('Limit Kredit', 'limit_kredit', number_format($limit_otorisasi->limit_kredit), ['class' => 'form-control currency'], null, 'text', true) }}
                {{ Form::fgText('Limit Debit', 'limit_debit', number_format($limit_otorisasi->limit_debit), ['class' => 'form-control currency'], null, 'text', true) }}
            </div>

            <div class="card-footer clearfix">
                {{ Form::fgFormButton('limit-otorisasi', $segment) }}
            </div>
        </div>
    {{ Form::close() }}
@endsection