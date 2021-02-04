@extends('layouts.app')
@section('title', 'Request File')
@section('content')
    <div class="card card-success">
        <div class="card-body">
            {{ Form::fgText('User', 'user_id', $data->user->profile->nama, ['class' => 'form-control', 'disabled'], null, 'text', true) }}
            {{ Form::fgText('File', 'filearchive_id', $data->filearchive->file_type->name, ['class' => 'form-control', 'disabled'], null, 'text', true) }}
            {{ Form::fgText('Description', 'description', $data->description, ['class' => 'form-control', 'disabled'], null, 'textarea', true) }}
        </div>
    </div>

    {{ Form::open(['route' => ['requestfile.storeapproval', $data->id], 'method' => 'post', 'class' => 'form-horizontal form-data', 'autocomplete' => 'off']) }}
    <div class="card card-success">
        <div class="card-body">
            {{ Form::fgSelect('Approval', 'status', to_dropdown($approval), null, ['class' => 'form-control'], null, true) }}
            <div class="form-group row">
                <label for="" class="col-md-2 col-form-label">Alasan</label>
                <div class="col-md-10">
                    {{ Form::textarea('alasan_tolak', null, ['class' => 'form-control']) }}
                </div>
            </div>
        </div>

        <div class="card-footer clearfix">
            {{ Form::fgFormButton('requestfile') }}
        </div>
    </div>
    {{ Form::close() }}
@endsection
