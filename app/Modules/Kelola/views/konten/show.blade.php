@php
$segment = request()->segment(2);
$title = 'create'; $method = 'post'; $action = 'kelola-konten.store';
if ($segment !== 'create' ) { $title = 'show'; $method = 'put'; $action = ['kelola-konten.update', $kelola_konten->id];
}
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' Kelola - Konten')
@section('content')
    {{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off', 'files' => true]) }}
    <div class="card card-success">
        <div class="card-body">
            {{ Form::fgText('Title', 'title', $kelola_konten->title, ['class' => 'form-control', 'disabled'], null, 'text', 'true') }}
            {{ Form::fgText('Description', 'description', $kelola_konten->description, ['class' => 'form-control', 'cols' => '20', 'rows' => '5', 'disabled'], null, 'textarea', true) }}
            <div class="form-group row">
                <label for="" class="col-md-2 col-form-label">Upload Image</label>
                @isset($kelola_konten->image)
                    <div class="col-md-5 text-center">
                        <img src="{{ asset('konten/' . $kelola_konten->image) }}" alt="logo" width="500" height="200"
                            style="margin-top: 0%">
                    </div>
                @endisset
                @if ($title == 'create' && $title == 'edit')
                    <div class="col-md-{{ isset($kelola_konten->image) ? '5' : '10' }}">
                        {!! Form::file($image, ['class' => 'form-control dropify', 'disabled']) !!}
                    </div>
                @endif
            </div>
            {{ Form::fgSelect('Status', 'status', to_dropdown($status_konten), $kelola_konten->status, ['class' => 'form-control', 'disabled'], null, true) }}
        </div>

        <div class="card-footer clearfix">
            <a href="{{ url()->previous() }}" class="btn btn-danger btn-sm">
                <i class="fa fa-times"></i> {{ __('button.back') }}
            </a>
        </div>
    </div>
    {{ Form::close() }}
@endsection
