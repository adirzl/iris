@php
    $segment = request()->segment(2);
    $title = 'create'; $method = 'post'; $action = 'rule-hak-akses.store';
    if ($segment !== 'create' ) { $title = 'edit'; $method = 'put'; $action = ['rule-hak-akses.update', $rule_hak_akse->id]; }
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' Rule Hak Akses')
@section('content')
    {{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off']) }}
        <div class="card card-success">
            <div class="card-body">
                <div class="form-group row">
                    <label for="" class="col-md-2 col-form-label">Grade</label>
                    <div class="col-md-10">
                        @isset($rule_hak_akse->grade)
                            @foreach($rule_hak_akse->grade as $g)
                                <div class="grade" id="grade{{ $loop->iteration }}">
                                    <div class="row mb-2">
                                        <div class="col-sm-8">
                                            {{ Form::select('grade[]', $grade, $g, ['class' => 'form-control']) }}
                                        </div>

                                        <div class="col-sm-4">
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
                            <div class="grade" id="grade0">
                                <div class="row mb-2">
                                    <div class="col-sm-8">
                                        {{ Form::select('grade[]', $grade, null, ['class' => 'form-control']) }}
                                    </div>

                                    <div class="col-sm-4">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-info m-r-5 add" id="add0">
                                            <i class="fa fa-plus"></i>
                                        </a>&nbsp;
                                        <a href="javascript:void(0);" class="btn btn-sm btn-danger rmv" id="rmv0">
                                            <i class="fa fa-minus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endisset
                    </div>
                </div>

                {{ Form::fgOption('Pegawai TI', 'pegawai_ti', $bool_decision, $rule_hak_akse->pegawai_ti, null, 'radio', true) }}
                {{ Form::fgOption('Ditunjuk sebagai Admin SPV TI', 'as_admin_spv', $bool_decision, $rule_hak_akse->as_admin_spv, null, 'radio', true) }}
                {{ Form::fgOption('Ditunjuk sebagai Admin TI', 'as_admin', $bool_decision, $rule_hak_akse->as_admin, null, 'radio', true) }}
                {{ Form::fgSelect('Level Hak Akses Primary', 'primary_level', to_dropdown($level_hakakses), $rule_hak_akse->primary_level, ['class' => 'form-control'], null, true) }}
                {{ Form::fgSelect('Level Hak Akses Secondary', 'secondary_level', to_dropdown($level_hakakses), $rule_hak_akse->secondary_level, ['class' => 'form-control'], null, true) }}
            </div>

            <div class="card-footer clearfix">
                {{ Form::fgFormButton('rule-hak-akses', $segment) }}
            </div>
        </div>
    {{ Form::close() }}
@endsection