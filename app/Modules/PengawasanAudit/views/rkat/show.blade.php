@php
$segment = request()->segment(2);
$title = 'create'; $method = 'post'; $action = 'rkat-audit.store';
if ($segment !== 'create' ) { $title = 'show'; $method = 'put'; $action = ['rkat-audit.update', $data->id]; }
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
        <div class="col-md-2">
            {{ Form::fgSelect('', 'ljk', to_dropdown($company_name), $data->ljk, ['class' => 'form-control', 'disabled'], null, false) }}
        </div>
        <div class="tab-content" id="custom-tabs-two-tabContent">
            <div class="tab-pane fade show active" id="auditumum" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
                <table class="table table-bordered" style="text-align:center; font-size : 12px">
                    <thead>
                        <tr>
                            <th rowspan="2" style="width:70px">No.</th>
                            <th rowspan="2" style="width:350px">Objek Audit / Judul Pemeriksaaan</th>
                            <th colspan="2" style="width:100px">Tanggal Pelaksanaan</th>
                            <th rowspan="2">Jumlah Temuan</th>
                            <th rowspan="2">Jumlah Tindak Lanjut</th>
                            <th rowspan="2">Keterangan</th>
                        </tr>
                        <tr>
                            <th style="width:150px">Mulai</th>
                            {{-- <th style="width:150px">Selesai</th>
                            <th style="width:150px">Memadai</th>
                            <th style="width:150px">Belum Sepenuhnya</th>
                            <th style="width:150px">Tidak Memadai</th> --}}
                        </tr>
                    </thead>
                    @foreach($data->rkataudit_umum as $d)
                    <tbody>
                        <td style="width:70px">{{ Form::text('', $d->sequence_umum, ['class' => 'form-control text-center', 'placeholder' => '', 'disabled']) }}</td>
                        <td style="width:350px">{{ Form::textarea('', $d->objek_judul_umum, ['class' => 'form-control', 'placeholder' => '', 'rows' => 1, 'cols' => 15, 'disabled']) }}</td>
                        <td>{{ Form::text('tgl_mulai_umum[]', $d->tgl_mulai_umum, ['class' => 'form-control reservation text-center', 'placeholder' => 'DD-MM-YYYY', 'id' => 'reservation', 'disabled']) }}</td>
                        <td>{{ Form::text('tgl_selesai_umum[]', $d->tgl_selesai_umum, ['class' => 'form-control reservation text-center', 'placeholder' => 'DD-MM-YYYY', 'id' => 'reservation', 'disabled']) }}</td>
                        <td>{{ Form::text('jml_temuan_umum[]', $d->jml_temuan_umum, ['class' => 'form-control text-center', 'placeholder' => '', 'disabled']) }}</td>
                        {{-- <td>{{ Form::checkbox('jml_tindak_lanjut_umum[]', 1, ($d->jml_tindak_lanjut_umum ==1 ? true:false), ['disabled']) }}</td>
                        <td>{{ Form::checkbox('jml_tindak_lanjut_umum[]', 2, ($d->jml_tindak_lanjut_umum ==2 ? true:false), ['disabled']) }}</td>
                        <td>{{ Form::checkbox('jml_tindak_lanjut_umum[]', 3, ($d->jml_tindak_lanjut_umum ==3 ? true:false), ['disabled']) }}</td> --}}
                        <td>
                            <select class="form-control" name="jml_tindak_lanjut_umum[]" disabled>
                              <option value="1" @if($d->jml_tindak_lanjut_umum == 1) selected @endif>Memadai</option>
                              <option value="2" @if($d->jml_tindak_lanjut_umum == 2) selected @endif>Belum Sepenuhnya</option>
                              <option value="3" @if($d->jml_tindak_lanjut_umum == 3) selected @endif>Tidak Memadai</option>
                            </select>
                          </td>
                        <td style="width:200px">{{ Form::textarea('keterangan_umum[]', $d->keterangan_umum, ['class' => 'form-control', 'placeholder' => '', 'rows' => 1, 'cols' => 15, 'disabled']) }}</td>
                    </tbody>
                    @endforeach
                </table>
            </div>
            <div class="tab-pane fade" id="auditkhusus" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
                <table class="table table-bordered" style="text-align:center; font-size : 12px">
                    <thead>
                        <tr>
                            <th rowspan="2" style="width:70px">No.</th>
                            <th rowspan="2" style="width:450px">Objek Audit / Judul Pemeriksaaan</th>
                            <th colspan="2" style="width:200px">Tanggal Pelaksanaan</th>
                            <th rowspan="2">Tindak Lanjut</th>
                            <th rowspan="2">Keterangan</th>
                        </tr>
                        <tr>
                            <th style="width:150px">Mulai</th>
                            <th style="width:150px">Selesai</th>
                        </tr>
                    </thead>
                    @foreach($data->rkataudit_khusus as $d)
                    <tbody>
                        <td style="width:70px">{{ Form::text('', $d->sequence_khusus, ['class' => 'form-control', 'placeholder' => '', 'disabled']) }}</td>
                        <td style="width:450px">{{ Form::textarea('', $d->objek_judul_khusus, ['class' => 'form-control', 'placeholder' => '', 'rows' => 1, 'cols' => 15, 'disabled']) }}</td>
                        <td>{{ Form::text('tgl_mulai_khusus[]', $d->tgl_mulai_khusus, ['class' => 'form-control reservation', 'placeholder' => 'DD-MM-YYYY', 'id' => 'reservation', 'disabled']) }}</td>
                        <td>{{ Form::text('tgl_selesai_khusus[]', $d->tgl_selesai_khusus, ['class' => 'form-control reservation', 'placeholder' => 'DD-MM-YYYY', 'id' => 'reservation', 'disabled']) }}</td>
                        <td>{{ Form::textarea('tindak_lanjut_khusus[]', $d->tindak_lanjut_khusus, ['class' => 'form-control', 'placeholder' => '', 'rows' => 1, 'cols' => 15, 'disabled']) }}</td>
                        <td style="width:100px">{{ Form::textarea('keterangan_khusus[]', $d->keterangan_khusus, ['class' => 'form-control', 'placeholder' => '', 'rows' => 1, 'cols' => 15, 'disabled']) }}</td>
                    </tbody>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer clearfix">
        {{-- <a href="{{ url()->previous() }}" class="btn btn-danger btn-sm">
            <i class="fa fa-times"></i> {{ __('button.back') }}
        </a> --}}
    </div>
</div>
{{ Form::close() }}
@endsection