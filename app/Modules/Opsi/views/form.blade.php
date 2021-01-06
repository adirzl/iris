@php
    $segment = request()->segment(2);
    $title = 'create'; $method = 'post'; $action = 'opsi.store';
    if ($segment !== 'create' ) { $title = 'edit'; $method = 'put'; $action = ['opsi.update', $opsi->id]; }
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' Opsi')
@section('content')
    {{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off']) }}
        <div class="card card-success">
            <div class="card-body">
                {{ Form::fgText('Nama Opsi', 'name', $opsi->name, ['class' => 'form-control alphadash lcase'], null, 'text', true) }}

                <div class="form-group row">
                    <label for="" class="col-md-2 col-form-label">Opsi</label>
                    <div class="col-md-10">
                        @if($opsi->optionValues->count())
                            @foreach($opsi->optionValues as $v)
                                <div class="options" id="options{{ $loop->iteration }}">
                                    <div class="row" style="margin-bottom:8px">
                                        <div class="col-sm-4">
                                            {{ Form::text('keys[]', $v->key, ['class' => 'form-control', 'placeholder' => 'Key Opsi']) }}
                                        </div>

                                        <div class="col-sm-4">
                                            {{ Form::text('values[]', $v->value, ['class' => 'form-control', 'placeholder' => 'Value Opsi']) }}
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
                        @endif
                    </div>
                </div>
            </div>

            <div class="card-footer clearfix">
                {{ Form::fgFormButton('opsi', $segment) }}
            </div>
        </div>
    {{ Form::close() }}
@endsection