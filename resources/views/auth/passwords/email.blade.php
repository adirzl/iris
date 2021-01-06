@extends('layouts.auth')
@section('title', __('label.reset_password'))
@section('content')
    {{ Form::open(['route' => 'password.email', 'method' => 'post', 'autocomplete' => 'off']) }}
        <div class="input-group mb-3">
            {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email']) }}
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary btn-block btn-flat">
                    {{ __('button.send') }}
                </button>
            </div>
        </div>
    {{ Form::close() }}

    <div class="text-center" style="margin-top:8px">
        <a href="{{ route('login') }}">{{ __('button.remember_password') }}</a>
    </div>
@endsection
