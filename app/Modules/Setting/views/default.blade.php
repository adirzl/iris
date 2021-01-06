@extends('layouts.app')
@section('title', 'Setting')
@section('content')
{{ Form::open(['route' => 'setting.update', 'method' => 'post', 'class' => 'form-horizontal form-data', 'autocomplete' => 'off', 'files' => true]) }}
<div class="card card-success">
    <div class="card-body">
        @foreach($data as $d)
        @php($label = \Illuminate\Support\Str::title(str_replace('_', ' ', $d->key)))
        @php(\Illuminate\Support\Arr::forget($display_per_page, 'All'))
        @if(in_array($d->key, ['display_per_page']))
        {{ Form::fgSelect($label, $d->key, to_dropdown($display_per_page), $d->value, ['class' => 'form-control'], $d->shortdesc, true) }}
        @elseif($d->key == 'verified_email')
        {{ Form::fgSelect($label, $d->key, to_dropdown($bool_decision), boolval($d->value), ['class' => 'form-control'], $d->shortdesc, true) }}
        @elseif($d->key == 'logo')
        <div class="form-group row">
            <label for="" class="col-md-2 col-form-label">{{ $label }}</label>
            @isset($d->value)
            <div class="col-md-2 text-center">
                <img src="{{ asset('img/' . $d->value) }}" alt="logo" width="120" height="120" style="margin-top: 20%">
            </div>
            @endisset
            <div class="col-md-{{ isset($d->value) ? '8' : '10' }}">
                {!! Form::file($d->key, ['class' => 'dropify']) !!}
            </div>
        </div>
        @else
        {{ Form::fgText($label, $d->key, $d->value, ['class' => 'form-control ' . ($d->key === 'expired_password_duration' ? 'number' : '')], $d->shortdesc, 'text', true) }}
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