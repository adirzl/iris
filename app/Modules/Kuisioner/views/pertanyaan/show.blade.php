@php
$segment = request()->segment(2);
$title = 'create'; $method = 'post'; $action = 'kuisioner-pertanyaan.store';
if ($segment !== 'create' ) { $title = 'show'; $method = 'put'; $action = ['kuisioner-pertanyaan.update', $kuisioner_pertanyaan->id]; }
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' Kuisioner - Pertanyaan')
@section('content')
{{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off', 'files' => true]) }}
<div class="card card-success">
    <div class="card-body">
        {{ Form::fgSelect('Kategori User', 'status_user', to_dropdown($status_user), $kuisioner_pertanyaan->status_user, ['class' => 'form-control', 'disabled'], null, true) }}
        {{ Form::fgText('Description', 'description', $kuisioner_pertanyaan->description, ['class' => 'form-control', 'cols' => '20', 'rows' => '5', 'disabled'], null, 'textarea', true) }}
        <div class="form-group row">
            <label for="" class="col-md-2 col-form-label">Pertanyaan</label>
            <div class="col-md-10">
                @foreach($kuisioner_pertanyaan->detail_pertanyaan as $v)
                <div class="row" style="margin-bottom:8px">
                    <div class="col-sm-8">
                        {{ Form::textarea('pertanyaan[]', $v->pertanyaan, ['class' => 'form-control', 'placeholder' => 'Pertanyaan', 'rows' => 3, 'cols' => 15, 'disabled']) }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        {{ Form::fgSelect('Status', 'status', to_dropdown($status_pertanyaan), $kuisioner_pertanyaan->status, ['class' => 'form-control', 'disabled'], null, true) }}
    </div>
    <div class="card-footer clearfix">
        <a href="{{ url()->previous() }}" class="btn btn-danger btn-sm">
            <i class="fa fa-times"></i> {{ __('button.back') }}
        </a>
    </div>
</div>
{{ Form::close() }}
@endsection