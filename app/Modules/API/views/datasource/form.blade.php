@php
    $segment = request()->segment(2);
    $title = 'create'; $method = 'post'; $action = 'datasource.store';
    if ($segment !== 'create' ) { $title = 'edit'; $method = 'put'; $action = ['datasource.update', $datasource->id]; }
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' Datasource')
@section('content')
    {{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off']) }}
        <div class="card card-success">
            <div class="card-body">
                {{ Form::fgText('Nama Datasource', 'nama', $datasource->nama, ['class' => 'form-control ucase'], null, 'text', true) }}
                {{ Form::fgSelect('Environment', 'environment', to_dropdown($environment), $datasource->environment, ['class' => 'form-control'], null, true) }}
                {{ Form::fgSelect('Dialect', 'dialect', to_dropdown($dialect), $datasource->dialect, ['class' => 'form-control'], null, true) }}
                
                <div class="form-group row">
                    <label for="" class="col-md-2 col-form-label">Properties</label>
                    <div class="col-md-10">
                        @isset($datasource->properties)
                        <div class="row mb-2">
                            @foreach(json_decode($datasource->properties, true) as $key => $value)
                                <div class="col-sm-6">
                                    {{ Form::text('key[]', $key, ['class' => 'form-control', 'readonly' => true]) }}
                                </div>

                                <div class="col-sm-6 {{ $loop->last ? '' : 'mb-3' }}">
                                    {{ Form::text('value[]', $value, ['class' => 'form-control']) }}
                                </div>
                            @endforeach
                        </div>
                        @else
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    {{ Form::text('key[]', 'driver', ['class' => 'form-control', 'readonly' => true]) }}
                                </div>

                                <div class="col-sm-6 mb-3">
                                    {{ Form::text('value[]', null, ['class' => 'form-control']) }}
                                </div>
                                
                                <div class="col-sm-6">
                                    {{ Form::text('key[]', 'server', ['class' => 'form-control', 'readonly' => true]) }}
                                </div>

                                <div class="col-sm-6 mb-3">
                                    {{ Form::text('value[]', null, ['class' => 'form-control']) }}
                                </div>

                                <div class="col-sm-6">
                                    {{ Form::text('key[]', 'port', ['class' => 'form-control', 'readonly' => true]) }}
                                </div>

                                <div class="col-sm-6 mb-3">
                                    {{ Form::text('value[]', null, ['class' => 'form-control']) }}
                                </div>

                                <div class="col-sm-6">
                                    {{ Form::text('key[]', 'database', ['class' => 'form-control', 'readonly' => true]) }}
                                </div>

                                <div class="col-sm-6 mb-3">
                                    {{ Form::text('value[]', null, ['class' => 'form-control']) }}
                                </div>

                                <div class="col-sm-6">
                                    {{ Form::text('key[]', 'username', ['class' => 'form-control', 'readonly' => true]) }}
                                </div>

                                <div class="col-sm-6 mb-3">
                                    {{ Form::text('value[]', null, ['class' => 'form-control']) }}
                                </div>

                                <div class="col-sm-6">
                                    {{ Form::text('key[]', 'password', ['class' => 'form-control', 'readonly' => true]) }}
                                </div>

                                <div class="col-sm-6">
                                    {{ Form::text('value[]', null, ['class' => 'form-control']) }}
                                </div>
                            </div>
                        @endisset
                    </div>
                </div>
            </div>

            <div class="card-footer clearfix">
                {{ Form::fgFormButton('datasource', $segment) }}
            </div>
        </div>
    {{ Form::close() }}
@endsection