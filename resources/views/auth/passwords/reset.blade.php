@extends('layouts.auth')
@section('title', 'Reset Password')
@section('content')
    {{ Form::open(['route' => 'password.update', 'method' => 'post', 'autocomplete' => 'off']) }}
        <div class="input-group mb-3">
            {{ Form::text('email', $email, ['class' => 'form-control', 'readonly' => true]) }}
            {{ Form::hidden('token', $token) }}
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>

        <div class="input-group mb-3">
            {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) }}
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>

        <div class="input-group mb-3">
            {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Konfirmasi Password']) }}
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary btn-block btn-flat">
                    {{ __('button.reset') }}
                </button>
            </div>
        </div>
    {{ Form::close() }}
@endsection
