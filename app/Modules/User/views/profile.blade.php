@extends('layouts.app')
@section('title', 'Profile')
@section('content')
    {{ Form::open(['route' => 'profile.update', 'method' => 'post', 'class' => 'form-horizontal form-data', 'autocomplete' => 'off']) }}
        <div class="card card-success">
            <div class="card-body">
                {{ Form::fgText('Hak Akses', '', $data->roles->pluck('name')->first(), ['class' => 'form-control', 'readonly' => true], null, 'text', true) }}
                {{ Form::fgText('Username', 'username', $data->username, ['class' => 'form-control'], null, 'text', true) }}
                {{ Form::fgPassword('Password', 'password', ['class' => 'form-control'], null, true) }}
                {{ Form::fgPassword('Konfirmasi Password', 'password_confirmation', ['class' => 'form-control'], null, true) }}
                {{ Form::fgText('Nama', 'nama', $data->profile->nama, ['class' => 'form-control'], null, 'text', true) }}
                {{ Form::fgText('NIP', 'nip', $data->profile->nip, ['class' => 'form-control number'], null, 'text', true) }}
                {{ Form::fgText('Email', 'email', $data->email, ['class' => 'form-control'], null, 'text', true) }}
                {{ Form::fgText('No. HP', 'hp', $data->profile->hp, ['class' => 'form-control number'], null, 'text', true) }}
            </div>

            <div class="card-footer clearfix">
                <button class="btn btn-primary btn-sm save-close">
                    <i class="fa fa-backward"></i> {{ __('button.save') }}
                </button>&nbsp;
                <button type="reset" class="btn btn-warning btn-sm reset">
                    <i class="fa fa-redo"></i> {{ __('button.reset') }}
                </button>
            </div>
        </div>
    {{ Form::close() }}
@endsection