@php
$segment = request()->segment(2);
$title = 'create'; $method = 'post'; $action = 'kelola-laporan.store';
if ($segment !== 'create' ) { $title = 'show'; $method = 'put'; $action = ['kelola-laporan.update', $kelola_laporan->id]; }
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' Kelola - Laporan')
@section('content')
{{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off', 'files' => true]) }}
<div class="card card-success">
    <div class="card-body">
        {{ Form::fgText('Title', 'title', $kelola_laporan->title, ['class' => 'form-control', 'disabled'], null, 'text', 'true') }}
        {{ Form::fgText('Description', 'description', $kelola_laporan->description, ['class' => 'form-control', 'cols' => '20', 'rows' => '5', 'disabled'], null, 'textarea', true) }}
        <!-- <div class="form-group row">
            <label for="" class="col-md-2 col-form-label">Upload Image</label>
            @isset($kelola_laporan->image)
            <div class="col-md-5 text-center">
                <img src="{{ asset('laporan/' . $kelola_laporan->image) }}" alt="logo" width="500" height="200" style="margin-top: 0%">
            </div>
            @endisset
            @if($title == 'create' && $title == 'edit')
            <div class="col-md-{{ isset($kelola_laporan->image) ? '5' : '10'}}">
                {!! Form::file($image, ['class' => 'form-control dropify', 'disabled']) !!}
            </div>
            @endif
        </div> -->
        <div class="form-group row">
            <label for="" class="col-md-2 col-form-label">Upload File</label>
            @isset($kelola_laporan->file)
            <div class="col-md-5 text-left">
                <a href="{{ asset('laporan_files/' . $kelola_laporan->file) }}" alt="file" width="500" height="200" style="margin-top: 0%" target="_blank">{{ $kelola_laporan->file }}</a>
            </div>
            @endisset
            @if($title == 'create' && $title == 'edit')
            <div class="col-md-{{ isset($kelola_laporan->file) ? '5' : '10'}}">
                {!! Form::file($file, ['class' => 'form-control', 'disabled']) !!}
            </div>
            @endif
        </div>
        {{ Form::fgSelect('Status', 'status', to_dropdown($status_laporan), $kelola_laporan->status, ['class' => 'form-control', 'disabled'], null, true) }}
    </div>

    <div class="card-footer clearfix">
        <a type="button" href="{{url('kelola-laporan')}}" class="btn btn-danger btn-sm"><i class="fa fa-arrow-circle-left"></i> {{ __('button.back') }}</a>&nbsp;
        @if($kelola_laporan->status_progres == 1)
        <a type="button" href="{{url('kelola-laporan/reject', $kelola_laporan->id)}}" class="btn btn-sm btn-flat btn-warning" title="Reject {{$kelola_laporan->title}}" rel="action"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Reject</a>&nbsp;
        <a type="button" href="{{url('kelola-laporan/approve', $kelola_laporan->id)}}" class="btn btn-sm btn-flat btn-success" title="Approve {{$kelola_laporan->title}}" rel="action"><i class="fa fa-arrow-circle-up"></i>&nbsp;&nbsp;Approve</a>&nbsp;
        @else
        @endif
    </div>
</div>
{{ Form::close() }}
@endsection