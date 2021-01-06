@php
$segment = request()->segment(2);
$title = 'create'; $method = 'post'; $action = 'sumber-data.store';
if ($segment !== 'create' ) { $title = 'edit'; $method = 'put'; $action = ['sumber-data.update', $sumber_data->id]; }
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' Sumber Data')
@section('content')
{{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off', 'files' => true]) }}
<div class="card card-success">
  <div class="card-body">
    {{ Form::fgSelect('Lembaga Jasa Keuangan', 'ljk', to_dropdown($ljk), $sumber_data->ljk, ['class' => 'form-control'], null, true) }}
    {{ Form::fgText('Periode Tahun', 'periode', null, ['class' => 'form-control reservation', 'placeholder' => 'DD-MM-YYYY', 'id' => 'reservation'], null, 'text', true) }}
    <div class="form-group row">
      <label for="" class="col-md-2 col-form-label">Kategori Sumber Data</label>
      <div class="col-md-10">
        <div class="options" id="options0">
          <div class="row" style="margin-bottom:8px">
            <div class="col-sm-8">
              {{ Form::fgSelect('','kategori[]', to_dropdown($ljk), null, ['class' => 'form-control'], null, true) }}
            </div>
            <div class="col-sm-3">
              {!! Form::file(null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-sm-1">
              <a href="javascript:void(0);" class="btn btn-sm btn-info m-r-5 add" id="add0">
                <i class="fa fa-plus"></i>
              </a>&nbsp;
              <a href="javascript:void(0);" class="btn btn-sm btn-danger rmv" id="rmv0">
                <i class="fa fa-minus"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    {{ Form::fgText('Antar Bank Aktiva', 'periode', null, ['class' => 'form-control', 'placeholder' => ''], null, 'text', true) }}
    {{ Form::fgText('Kredit Diberikan', 'periode', null, ['class' => 'form-control', 'placeholder' => ''], null, 'text', true) }}
    {{ Form::fgText('ATI', 'periode', null, ['class' => 'form-control', 'placeholder' => ''], null, 'text', true) }}
    {{ Form::fgText('Rupa Rupa Aktiva', 'periode', null, ['class' => 'form-control', 'placeholder' => ''], null, 'text', true) }}
    {{ Form::fgText('Modal Disetor', 'periode', null, ['class' => 'form-control', 'placeholder' => ''], null, 'text', true) }}
    {{ Form::fgText('Cadangan Umum', 'periode', null, ['class' => 'form-control', 'placeholder' => ''], null, 'text', true) }}
    {{ Form::fgText('Cadangan Tujuan', 'periode', null, ['class' => 'form-control', 'placeholder' => ''], null, 'text', true) }}
    {{ Form::fgText('Laba/Rugi Tahun Lalu', 'periode', null, ['class' => 'form-control', 'placeholder' => ''], null, 'text', true) }}
    {{ Form::fgText('Modal Pelengkap 1.25% ATMR', 'periode', null, ['class' => 'form-control', 'placeholder' => ''], null, 'text', true) }}
    {{ Form::fgText('God Will', 'periode', null, ['class' => 'form-control', 'placeholder' => ''], null, 'text', true) }}
    {{ Form::fgText('CAR', 'periode', null, ['class' => 'form-control', 'placeholder' => ''], null, 'text', true) }}
  </div>
</div>
<div class="card-footer clearfix">
  {{ Form::fgFormButton('kuisioner-pertanyaan', $segment) }}
</div>
</div>
{{ Form::close() }}
@endsection

