@php
$segment = request()->segment(2);
$title = 'create'; $method = 'post'; $action = 'rkat-audit.store';
if ($segment !== 'create' ) { $title = 'edit'; $method = 'put'; $action = ['rkat-audit.update', $rkat_audit->id]; }
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' RKAT - Audit')
@section('content')
{{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off']) }}
<div class="card">
  <div class="card-header p-0 pt-1 border-bottom-0">
    <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#auditumum" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Audit Umum</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#auditkhusus" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">Audit Khusus/Investigasi</a>
      </li>
    </ul>
  </div>
  <div class="card-body">
    <div class="col-md-3">
      {{ Form::fgSelect('Lembaga Jasa Keuangan', 'ljk', to_dropdown($company_name), $rkat_audit->ljk, ['class' => 'form-control'], null, false) }}
      <p style="color: red; font-size: 10px">*Lembaga Jasa Keuangan Wajib di Isi</p>
    </div>
    <div class="tab-content" id="custom-tabs-two-tabContent">
      <div class="tab-pane fade show active" id="auditumum" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
        <table class="table table-bordered " style="text-align: center; font-size: 12px; ">
          <thead>                  
            <tr>
              <th rowspan="2" style="width:100px"></th>
              <th rowspan="2" style="width:70px">No.</th>
              <th rowspan="2" style="width:300px">Objek Audit / Judul Pemeriksaaan</th>
              <th colspan="2" style="width:200px">Tanggal Pelaksanaan</th>
              <th rowspan="2" style="width:80px">Jumlah Temuan</th>
              <th rowspan="2">Tindak Lanjut</th>
              <th rowspan="2" style="width:200px">Keterangan</th>
            </tr>
            <tr>
              <th style="width:150px">Mulai</th>
              <th style="width:150px">Selesai</th>
              {{-- <th style="width:100px">Memadai</th>
              <th style="width:100px">Belum Sepenuhnya</th>
              <th style="width:100px">Tidak Memadai</th> --}}
            </tr>
          </thead>
          @if($rkat_audit->rkataudit_umum->count())
            @foreach($rkat_audit->rkataudit_umum as $d)
            <tbody class="rkatumum" id="rkatumum{{ $loop->iteration }}">
              <tr>
                <td class="text-center">
                  <a href="javascript:void(0);" class="btn btn-sm btn-info m-r-5 add" id="add{{ $loop->iteration }}">
                    <i class="fa fa-plus"></i>
                  </a>&nbsp;
                  <a href="javascript:void(0);" class="btn btn-sm btn-danger rmv" id="rmv{{ $loop->iteration }}">
                    <i class="fa fa-minus"></i>
                  </a>
                </td>
                <td style="width:70px">{{ Form::text('sequence_umum[]', $d->sequence_umum, ['class' => 'form-control number', 'placeholder' => '']) }}</td>
                <td style="width:300px">{{ Form::text('objek_judul_umum[]', $d->objek_judul_umum, ['class' => 'form-control', 'placeholder' => '', 'rows' => 1, 'cols' => 15]) }}</td>
                <td>{{ Form::text('tgl_mulai_umum[]', $d->tgl_mulai_umum, ['class' => 'form-control reservation', 'placeholder' => 'YYYY-MM-DD', 'id' => 'reservation']) }}</td>
                <td>{{ Form::text('tgl_selesai_umum[]', $d->tgl_selesai_umum, ['class' => 'form-control reservation', 'placeholder' => 'YYYY-MM-DD', 'id' => 'reservation']) }}</td>
                <td>{{ Form::text('jml_temuan_umum[]', $d->jml_temuan_umum, ['class' => 'form-control', 'placeholder' => '']) }}</td>
                {{-- <td>{{ Form::checkbox('jml_tindak_lanjut_umum[]', 1, ($d->jml_tindak_lanjut_umum ==1 ? true:false)) }}</td>
                <td>{{ Form::checkbox('jml_tindak_lanjut_umum[]', 2, ($d->jml_tindak_lanjut_umum ==2 ? true:false)) }}</td>
                <td>{{ Form::checkbox('jml_tindak_lanjut_umum[]', 3, ($d->jml_tindak_lanjut_umum ==3 ? true:false)) }}</td> --}}
                <td>
                  <select class="form-control" name="jml_tindak_lanjut_umum[]">
                    <option value="1" @if($d->jml_tindak_lanjut_umum == 1) selected @endif>Memadai</option>
                    <option value="2" @if($d->jml_tindak_lanjut_umum == 2) selected @endif>Belum Sepenuhnya</option>
                    <option value="3" @if($d->jml_tindak_lanjut_umum == 3) selected @endif>Tidak Memadai</option>
                  </select>
                </td>
                <td style="width:200px">{{ Form::text('keterangan_umum[]', $d->keterangan_umum, ['class' => 'form-control', 'placeholder' => '', 'rows' => 1, 'cols' => 15]) }}</td>
              </tr>
            </tbody>
            @endforeach
          @else
          <tbody class="rkatumum" id="rkatumum0">
            <tr>
              <td class="text-center">
                <a href="javascript:void(0);" class="btn btn-sm btn-info m-r-5 add" id="add0">
                  <i class="fa fa-plus"></i>
                </a>&nbsp;
                <a href="javascript:void(0);" class="btn btn-sm btn-danger rmv" id="rmv0">
                  <i class="fa fa-minus"></i>
                </a>
              </td>
              <td style="width:70px">{{ Form::text('sequence_umum[]', null, ['class' => 'form-control number', 'placeholder' => '']) }}</td>
              <td style="width:300px">{{ Form::text('objek_judul_umum[]', null, ['class' => 'form-control', 'placeholder' => '', 'rows' => 1, 'cols' => 15]) }}</td>
              <td>{{ Form::text('tgl_mulai_umum[]', null, ['class' => 'form-control reservation', 'placeholder' => 'YYYY-MM-DD', 'id' => 'reservation']) }}</td>
              <td>{{ Form::text('tgl_selesai_umum[]', null, ['class' => 'form-control reservation', 'placeholder' => 'YYYY-MM-DD', 'id' => 'reservation']) }}</td>
              <td>{{ Form::text('jml_temuan_umum[]', null, ['class' => 'form-control', 'placeholder' => '']) }}</td>
              {{-- <td>{{ Form::checkbox('jml_tindak_lanjut_umum[]', 1, false) }}</td>
              <td>{{ Form::checkbox('jml_tindak_lanjut_umum[]', 2, false) }}</td>
              <td>{{ Form::checkbox('jml_tindak_lanjut_umum[]', 3, false) }}</td> --}}
              <td>
                <select class="form-control" name="jml_tindak_lanjut_umum[]">
                  <option value="3">Tidak Memadai</option>
                  <option value="2">Belum Sepenuhnya</option>
                  <option value="1">Memadai</option>
                </select>
              </td>
              <td style="width:200px">{{ Form::text('keterangan_umum[]', null, ['class' => 'form-control', 'placeholder' => '', 'rows' => 1, 'cols' => 15]) }}</td>
            </tr>
          </tbody>
          @endif
        </table>
      </div>
      <div class="tab-pane fade" id="auditkhusus" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
        <table class="table table-bordered" style="text-align:center; font-size : 12px">
          <thead>                  
            <tr>
              <th rowspan="2" style="width:100px"></th>
              <th rowspan="2" style="width:70px">No.</th>
              <th rowspan="2" style="width:350px">Objek Audit / Judul Pemeriksaaan</th>
              <th colspan="2" style="width:200px">Tanggal Pelaksanaan</th>
              <th rowspan="2">Tindak Lanjut</th>
              <th rowspan="2">Keterangan</th>
            </tr>
            <tr>
              <th style="width:150px">Mulai</th>
              <th style="width:150px">Selesai</th>
            </tr>
          </thead>
          @if($rkat_audit->rkataudit_khusus->count())
          @foreach($rkat_audit->rkataudit_khusus as $v)
          <tbody class="rkatkhusus" id="rkatkhusus{{ $loop->iteration }}">
            <tr>
              <td class="text-center">
                <a href="javascript:void(0);" class="btn btn-sm btn-info m-r-5 add" id="add{{ $loop->iteration }}">
                  <i class="fa fa-plus"></i>
                </a>&nbsp;
                <a href="javascript:void(0);" class="btn btn-sm btn-danger rmv" id="rmv{{ $loop->iteration }}">
                  <i class="fa fa-minus"></i>
                </a>
              </td>
              <td style="width:70px">{{ Form::text('sequence_khusus[]', $v->sequence_khusus, ['class' => 'form-control number', 'placeholder' => '']) }}</td>
              <td style="width:350px">{{ Form::text('objek_judul_khusus[]', $v->objek_judul_khusus, ['class' => 'form-control', 'placeholder' => '', 'rows' => 1, 'cols' => 15]) }}</td>
              <td>{{ Form::text('tgl_mulai_khusus[]', $v->tgl_mulai_khusus, ['class' => 'form-control reservation', 'placeholder' => 'YYYY-MM-DD', 'id' => 'reservation']) }}</td>
              <td>{{ Form::text('tgl_selesai_khusus[]', $v->tgl_selesai_khusus, ['class' => 'form-control reservation', 'placeholder' => 'YYYY-MM-DD', 'id' => 'reservation']) }}</td>
              <td>{{ Form::text('tindak_lanjut_khusus[]', $v->tindak_lanjut_khusus, ['class' => 'form-control', 'placeholder' => '', 'rows' => 1, 'cols' => 15]) }}</td>
              <td style="width:200px">{{ Form::text('keterangan_khusus[]', $v->keterangan_khusus, ['class' => 'form-control', 'placeholder' => '', 'rows' => 1, 'cols' => 15]) }}</td>
            </tr>
          </tbody>
          @endforeach
          @else
          <tbody class="rkatkhusus" id="rkatkhusus0">
            <tr>
              <td class="text-center">
                <a href="javascript:void(0);" class="btn btn-sm btn-info m-r-5 add" id="add0">
                  <i class="fa fa-plus"></i>
                </a>&nbsp;
                <a href="javascript:void(0);" class="btn btn-sm btn-danger rmv" id="rmv0">
                  <i class="fa fa-minus"></i>
                </a>
              </td>
              <td style="width:70px">{{ Form::text('sequence_khusus[]', null, ['class' => 'form-control number', 'placeholder' => '']) }}</td>
              <td style="width:350px">{{ Form::text('objek_judul_khusus[]', null, ['class' => 'form-control', 'placeholder' => '', 'rows' => 1, 'cols' => 15]) }}</td>
              <td>{{ Form::text('tgl_mulai_khusus[]', null, ['class' => 'form-control reservation', 'placeholder' => 'YYYY-MM-DD', 'id' => 'reservation']) }}</td>
              <td>{{ Form::text('tgl_selesai_khusus[]', null, ['class' => 'form-control reservation', 'placeholder' => 'YYYY-MM-DD', 'id' => 'reservation']) }}</td>
              <td>{{ Form::text('tindak_lanjut_khusus[]', null, ['class' => 'form-control', 'placeholder' => '', 'rows' => 1, 'cols' => 15]) }}</td>
              <td style="width:200px">{{ Form::text('keterangan_khusus[]', null, ['class' => 'form-control', 'placeholder' => '', 'rows' => 1, 'cols' => 15]) }}</td>
            </tr>
          </tbody>
          @endif
        </table>
      </div>
    </div>
  </div>
  <div class="card-footer clearfix">
    {{ Form::fgFormButton('rkat-audit', $segment) }}
  </div>
</div>
{{ Form::close() }}
@endsection



