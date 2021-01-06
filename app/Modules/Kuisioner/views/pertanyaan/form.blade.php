@php
    $segment = request()->segment(2);
    $title = 'create'; $method = 'post'; $action = 'kuisioner-pertanyaan.store';
    if ($segment !== 'create' ) { $title = 'edit'; $method = 'put'; $action = ['kuisioner-pertanyaan.update', $kuisioner_pertanyaan->id]; }
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' Kuisioner - Pertanyaan')
@section('content')
    {{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off']) }}
    <div class="card card-success">
        <div id="kuisioner_manrisk" class="card-body">
            {{ Form::fgSelect('Kategori User', 'status_user', to_dropdown($status_user), $kuisioner_pertanyaan->status_user, ['id' => 'leave', 'class' => 'form-control', 'onchange' => 'leaveChange()'], null, true) }}
            {{ Form::fgText('Ketegori Pertanyaan', 'description', $kuisioner_pertanyaan->description, ['class' => 'form-control', 'placeholder' => 'Deskripsi'], null, 'text', true) }}
                <div class="form-group row">
                    <label id="message" class="col-md-2 col-form-label">Pertanyaan</label>
                    <div class="col-md-10">
                        @if($kuisioner_pertanyaan->detail_pertanyaan->count())
                            @foreach($kuisioner_pertanyaan->detail_pertanyaan as $v)
                            <div class="options" id="options{{ $loop->iteration }}">
                                <div class="row" style="margin-bottom:8px">
                                    <div class="col-sm-8">
                                            {{ Form::hidden('id[]', $v->id) }}
                                            {{ Form::textarea('pertanyaan[]', $v->pertanyaan, ['class' => 'form-control', 'placeholder' => 'Pertanyaan', 'rows' => 3, 'cols' => 15]) }}
                                        </div>

                                        <div class="col-sm-2">
                                            <a href="javascript:void(0);" class="btn btn-sm btn-info m-r-5 add" id="add{{ $loop->iteration }}">
                                                <i class="fa fa-plus"></i>
                                            </a>&nbsp;
                                            <a href="javascript:void(0);" class="btn btn-sm btn-danger rmv" id="rmv{{ $loop->iteration }}">
                                                <i class="fa fa-minus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="options" id="options0">
                                <div class="row" style="margin-bottom:8px">
                                    <div class="col-sm-8">
                                        {{ Form::hidden('id[]', null) }}
                                        {{ Form::textarea('pertanyaan[]', null, ['class' => 'form-control', 'placeholder' => 'Pertanyaan', 'rows' => 3, 'cols' => 15]) }}
                                    </div>

                                    <div class="col-sm-2">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-info m-r-5 add" id="add0">
                                            <i class="fa fa-plus"></i>
                                        </a>&nbsp;
                                        <a href="javascript:void(0);" class="btn btn-sm btn-danger rmv" id="rmv0">
                                            <i class="fa fa-minus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                {{ Form::fgSelect('Status', 'status', to_dropdown($status_pertanyaan), $kuisioner_pertanyaan->status, ['class' => 'form-control'], null, true) }}
            </div>
            <div class="card-footer clearfix">
                {{ Form::fgFormButton('kuisioner-pertanyaan', $segment) }}
            </div>
        </div>
    {{ Form::close() }}
@endsection