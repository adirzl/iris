@php
$segment = request()->segment(2);
$title = 'create'; $method = 'post'; $action = 'dokumen-filetype.store';

@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' Dokumen - Tipe dan Nama')
@section('content')


{{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off']) }}
        <div class="card card-success">
            <div class="card-body">

                {{ Form::fgSelect('Unit Kerja', 'unitkerja_kode',$unitkerja, $kode, ['class' => 'form-control'], null, 'text', true) }}

                <div class="form-group row">
                    <label for="" class="col-md-3 col-form-label">Tipe</label>
                    <div class="col-md-9">
                                @if(count($filetype))
                                @foreach($filetype as $f)
                                <div >
                                    <div class="row" style="margin-bottom:8px">
                                        <div class="col-sm-4">
                                            {{ Form::text('f[]', $f->name, ['class' => 'form-control', 'placeholder' => 'tipe','readonly']) }}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                                

                            <div class="options" id="options0">
                                <div class="row" style="margin-bottom:8px">
                                    <div class="col-sm-4">
                                        {{ Form::text('name[]', null, ['class' => 'form-control', 'placeholder' => 'Tipe']) }}
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
                {{ Form::fgFormButton('dokumen-filetype', $segment) }}
            </div>
        </div>
    {{ Form::close() }}

@endsection