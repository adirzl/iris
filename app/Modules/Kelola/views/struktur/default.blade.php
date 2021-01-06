@extends('layouts.app')
@section('title', 'Struktur')
@section('content')
{{ Form::open(['route' => 'kelola-struktur.update', 'method' => 'post', 'class' => 'form-horizontal form-data', 'autocomplete' => 'off', 'files' => true]) }}
<div class="card card-success">
    <div class="card-body">
        @foreach($data as $d)
        @php($label = \Illuminate\Support\Str::title(str_replace('_', ' ', $d->key)))
        <!-- {{ Form::fgText('Title', $d->key, $d->value, ['class' => 'form-control'], null, 'text', true) }}
        {{ Form::fgText('Description', $d->key, $d->value, ['class' => 'form-control', 'cols' => '20', 'rows' => '5'], null, 'textarea', true) }}
        <div class="form-group row">
            <label for="" class="col-md-2 col-form-label">Upload Image</label>
            @isset($d->value)
            <div class="col-md-5 text-center">
                <img src="{{ asset('struktur/' . $d->value) }}" alt="logo" width="500" height="200" style="margin-top: 0%">
            </div>
            @endisset
            <div class="col-md-{{ isset($d->key) ? '5' : '10'}}">
                {!! Form::file($d->key, ['class' => 'form-control dropify']) !!}
            </div>
        </div> -->
        @if($d->key == 'image')
        <div class="form-group row">
            <label for="" class="col-md-2 col-form-label">Upload Image</label>
            @isset($d->value)
            <div class="col-md-5 text-center">
                <img src="{{ asset('struktur/' . $d->value) }}" alt="logo" width="500" height="200" style="margin-top: 0%">
            </div>
            @endisset
            <div class="col-md-{{ isset($d->key) ? '5' : '10'}}">
                {!! Form::file($d->key, ['class' => 'form-control dropify']) !!}
            </div>
        </div>
        @else
        {{ Form::fgText($label, $d->key, $d->value, ['class' => 'form-control '], $d->shortdesc, 'text', true) }}
        @endif
        @endforeach
    </div>

    <div class="card-footer clearfix">
        <button class="btn btn-success btn-sm save">
            <i class="fa fa-save"></i> {{ __('button.save') }}
        </button>&nbsp;
        <button type="reset" class="btn btn-warning btn-sm reset">
            <i class="fa fa-refresh"></i> {{ __('button.reset') }}
        </button>&nbsp;
    </div>
</div>
{{ Form::close() }}
@endsection