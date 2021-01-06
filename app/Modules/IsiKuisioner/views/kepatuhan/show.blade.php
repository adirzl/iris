@php
$segment = request()->segment(2);
$title = 'create'; $method = 'post'; $action = 'isikuisioner-kepatuhan.store';
if ($segment !== 'create' ) { $title = 'show'; $method = 'put'; $action = ['isikuisioner-kepatuhan.update', $isikuisioner->id]; }
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' Kuisioner - Penilaian')
@section('content')
{{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off', 'files' => true]) }}
<div class="card card-success">
    <div class="col-md-12 text-right mb-3" style="margin-right: 3%; margin-top: 2%">
        <a href="{{ url('kuisioner-penilaian/export/'.$isikuisioner->id.'?type=xls') }}" class="btn btn-success export-file">
            <i class="fa fa-file-excel"></i> {{ __('button.export', ['label' => 'XLS']) }}
        </a>&nbsp;
        {{-- <a href="{{ url('kuisioner-penilaian/export/'.$kuisioner->id.'?type=pdf') }}" class="btn btn-danger export-file">
            <i class="fa fa-file-pdf"></i> {{ __('button.export', ['label' => 'PDF']) }}
        </a> --}}
    </div>
    <hr>
    <div class="card-body">
            <center>
            <h4><strong>Kertas Kerja Pemantauan Fungsi Kepatuhan</strong></h4>
            <h4><strong>Pada Perusahaan Anak Dan Perusahaan Terelasi</strong></h4>
            </center>
    </div>
    <hr>

    <div id="isikuisioner-kepatuhan" class="card-body">
        {{ Form::fgSelect('Periode', 'periode', to_dropdown($periode), $isikuisioner->periode, ['class' => 'form-control col-md-5', 'disabled'], null, true) }}
        {{ Form::fgSelect('Nama Anak Perusahaan', 'nama_perusahaan', to_dropdown($company_name), $isikuisioner->nama_perusahaan, ['class' => 'form-control col-md-5', 'disabled'], null, true) }}
        {{ Form::fgText('Modal Inti', 'modal_inti', $isikuisioner->modal_inti, ['class' => 'form-control col-md-5 currency', 'disabled'], null, 'text', true) }}
        {{ Form::fgText('Nama Pengisi Kuisioner', 'user', $isikuisioner->user, ['class' => 'form-control col-md-5','disabled'], null, 'text', true) }}

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

    </div>

    <div class="card-footer clearfix">
        <a href="{{ url()->previous() }}" class="btn btn-danger btn-sm">
            <i class="fa fa-times"></i> {{ __('button.back') }}
        </a>
    </div>
</div>
{{ Form::close() }}
@endsection