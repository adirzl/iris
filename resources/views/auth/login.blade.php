@extends('layouts.auth')
@section('title', 'Login')
@section('content')
    {{ Form::open(['route' => 'login', 'method' => 'post', 'name' => 'form-login', 'autocomplete' => 'off']) }}
    <div class="input-group mb-3">
        {{ Form::text('username', null, ['class' => 'form-control ucase', 'placeholder' => 'Username']) }}
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-user"></span>
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

    <div class="row">
        <div class="col-12">
            <button class="btn btn-primary btn-block btn-flat">
                {{ __('button.login') }}
            </button>
        </div>
    </div>
    {{ Form::close() }}
@endsection
