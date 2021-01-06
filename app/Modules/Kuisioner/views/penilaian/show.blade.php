@php
$segment = request()->segment(2);
$title = 'create'; $method = 'post'; $action = 'kuisioner-penilaian.store';
if ($segment !== 'create' ) { $title = 'show'; $method = 'put'; $action = ['kuisioner-penilaian.update', $kuisioner->id]; }
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' Kuisioner - Penilaian')
@section('content')
{{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off', 'files' => true]) }}
<div class="card card-success">
    <div class="col-md-12 text-right mb-3" style="margin-right: 3%; margin-top: 2%">
        <a href="{{ url('kuisioner-penilaian/export/'.$kuisioner->id.'?type=xls') }}" class="btn btn-success export-file">
            <i class="fa fa-file-excel"></i> {{ __('button.export', ['label' => 'XLS']) }}
        </a>&nbsp;
        {{-- <a href="{{ url('kuisioner-penilaian/export/'.$kuisioner->id.'?type=pdf') }}" class="btn btn-danger export-file">
            <i class="fa fa-file-pdf"></i> {{ __('button.export', ['label' => 'PDF']) }}
        </a> --}}
    </div>
    <hr>
    <div class="card-body">
        @if($kuisioner->status_kuisioner == 1)
            <center>
            <h4><strong>Kuisioner  (User Manrisk LJK & User Manrisk Bjb)</strong></h4>
            <h4><strong>Penerapan Manajemen Risiko di BPR</strong></h4>
            <h4><strong>Divisi Manajemen Risiko</strong></h4>
            </center>
        @else
            <center>
            <h4><strong>Kertas Kerja Pemantauan Fungsi Kepatuhan</strong></h4>
            <h4><strong>Pada Perusahaan Anak Dan Perusahaan Terelasi</strong></h4>
            </center>
        @endif
    </div>
    <hr>
    <div id="kuisioner-penilaian" class="card-body">
        {{ Form::fgSelect('Periode', 'periode', to_dropdown($periode), $kuisioner->periode, ['class' => 'form-control col-md-5', 'disabled'], null, true) }}
        {{ Form::fgSelect('Nama Anak Perusahaan', 'nama_perusahaan', to_dropdown($company_name), $kuisioner->nama_perusahaan, ['class' => 'form-control col-md-5', 'disabled'], null, true) }}
        {{ Form::fgText('Modal Inti', 'modal_inti', $kuisioner->modal_inti, ['class' => 'form-control col-md-5 currency', 'disabled'], null, 'text', true) }}
        {{ Form::fgText('Nama Pengisi Kuisioner', 'user', $kuisioner->user, ['class' => 'form-control col-md-5','disabled'], null, 'text', true) }}

        <br>
        @if($kuisioner->status_kuisioner == 1)
            @foreach ($data_pertanyaan as $data)
            <br>
            <h4>{{ $data->description }}</h4>

            <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                <thead>
                    <tr>
                        <th>No</th>
                        <th style="width: 30%;">Pertanyaan Kuisioner</th>
                        <th>Penilaian</th>
                        <th>Bukti Implementasi</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($data->detail_pertanyaan->where('id_induk',$data->id) as $vd)
                    {{ Form::hidden('id_pertanyaan[]', $vd->id_induk) }}
                    {{ Form::hidden('id_pertanyaan_detail[]', $vd->id) }}
                    <tr>
                        <td>{{ $vd->no_pertanyaan }}</td>
                        <td>{{ $vd->pertanyaan }}</td>
                        @foreach($data_penilaian->where('id_pertanyaan_detail', $vd->id) as $v2)
                        <td>{{ $v2->jawaban !== '-' ? $jawaban[$v2->jawaban] : $v2->jawaban }}</td>
                        <td><a href="{{ asset('penilaian_files/' . $v2->file) }}" target="_blank">{{ $v2->file }}</a></td>
                        <td>{{ Form::fgText2('description[]', $v2->description, ['class' => 'form-control','cols' => '20', 'rows' => '7', 'disabled'], null, 'textarea', true) }}</td>
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
            </table>
            @endforeach
        @else
            @foreach ($data_pertanyaan as $data)
            <br>
            <h4>{{ $data->description }}</h4>

            <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jawaban</th>
                        <th>
                            Tandai Salah Satu
                        </th>
                        <th>Keterangan</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($data->detail_pertanyaan->where('id_induk',$data->id) as $vd)
                    {{ Form::hidden('id_pertanyaan[]', $vd->id_induk) }}
                    {{ Form::hidden('id_pertanyaan_detail[]', $vd->id) }}
                    <tr>
                        <td>{{ $vd->no_pertanyaan }}</td>
                        <td>{{ $vd->pertanyaan }}</td>
                        <td>
                            @foreach($data_penilaian->where('id_pertanyaan_detail', $vd->id) as $v2)
                            {{ Form::checkbox('jawaban[]',null, $a = ($v2->jawaban == 1) ? true : false, ['onclick' => 'return false']) }}
                        </td>
                        <td>{{ Form::fgText2('description[]', $v2->description, ['class' => 'form-control','cols' => '10', 'rows' => '5', 'disabled'], null, 'textarea', true) }}</td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endforeach
        @endif

        
    </div>

    <div class="card-footer clearfix">
        <a type="button" href="{{ url()->previous() }}" class="btn btn-warning btn-sm">
            <i class="fa fa-times"></i> {{ __('button.back') }}
        </a>&nbsp;
        @if($kuisioner->status == 1)
        <a type="button" href="{{url('kuisioner-penilaian/reject', $kuisioner->id)}}" class="btn btn-sm btn-danger" title="Reject {{$kuisioner->title}}" rel="action"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Reject</a>&nbsp;
        <a type="button" href="{{url('kuisioner-penilaian/approve', $kuisioner->id)}}" class="btn btn-sm btn-success" title="Approve {{$kuisioner->title}}" rel="action"><i class="fa fa-arrow-circle-up"></i>&nbsp;&nbsp;Approve</a>&nbsp;
        @else
        @endif
    </div>
</div>
{{ Form::close() }}
@endsection