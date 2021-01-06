@php
$segment = request()->segment(2);
$title = 'create'; $method = 'post'; $action = 'dmtl-audit.store';
if ($segment !== 'create' ) { $title = 'edit'; $method = 'put'; $action = ['dmtl-audit.update', $dmtl_audit->id]; }
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' DMTL - Audit')
@section('content')
{{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off', 'files' => true]) }}
<div class="card card-success">
  <div class="card-body">
    <div class="col-md-2">
      {{ Form::fgSelect('', 'ljk', to_dropdown($ljk), null, ['class' => 'form-control'], null, false) }}
    </div>
    <table class="table table-bordered addrows">
      <thead>                  
        <tr>
          <th style="width: 40px"></th>
          <th style="width: 400px">Fokus Audit</th>
          <th style="width: 400px">Sub Temuan</th>
          <th>Rekomendasi</th>
        </tr>
      </thead>
      <tbody class="dmtl" id="dmtl0"> 
        <tr>
          <td>
            <a href="javascript:void(0);" class="btn btn-sm btn-info m-r-5 adds" id="adds0">
              <i class="fa fa-plus"></i>
            </a>&nbsp;
            <a href="javascript:void(0);" class="btn btn-sm btn-danger rmvs" id="rmvs0">
              <i class="fa fa-minus"></i>
            </a>
          </td>
          <td>{{ Form::textarea('dmtl_fokus_audit[]', null, ['class' => 'form-control', 'placeholder' => '', 'rows' => 4, 'cols' => 15]) }}</td>
          <td>
            <table style="width: 100%">
              <tbody class="dmtls" id="dmtls0">
                <tr>
                  <td style="width: 95px">
                    <a href="javascript:void(0);" class="btn btn-sm btn-info m-r-5 add" id="add0">
                      <i class="fa fa-plus"></i>
                    </a>&nbsp;
                    <a href="javascript:void(0);" class="btn btn-sm btn-danger rmv" id="rmv0">
                      <i class="fa fa-minus"></i>
                    </a>
                  </td>
                  <td>{{ Form::textarea('dmtl_fokus_audit[]', null, ['class' => 'form-control', 'placeholder' => '', 'rows' => 1, 'cols' => 15]) }}</td>
                </tr>
              </tbody>
            </table> 
          </td>
          <td>
            {{-- <table style="width: 100%">
              <tbody class="dmtlrekomendasi" id="dmtlrekomendasi0">
                <tr>
                  <td style="width: 75px">
                    <a href="javascript:void(0);" class="btn btn-sm btn-info m-r-5 add" id="add0">
                      <i class="fa fa-plus"></i>
                    </a>&nbsp;
                    <a href="javascript:void(0);" class="btn btn-sm btn-danger rmv" id="rmv0">
                      <i class="fa fa-minus"></i>
                    </a>
                  </td>
                  <td style="width: 330px">{{ Form::textarea('dmtl_fokus_audit[]', null, ['class' => 'form-control', 'placeholder' => '', 'rows' => 1, 'cols' => 15]) }}</td>
                </tr>
              </tbody>
            </table>   --}}
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="card-footer clearfix">
    {{ Form::fgFormButton('kuisioner-pertanyaan', $segment) }}
  </div>
</div>
{{ Form::close() }}
@endsection

