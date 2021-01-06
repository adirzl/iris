@php
$segment = request()->segment(2);
$title = 'create'; $method = 'post'; $action = 'isikuisioner-manrisk.store';
if ($segment !== 'create' ) { $title = 'edit'; $method = 'put'; $action = ['isikuisioner-manrisk.update', $isikuisioner->id]; }
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' Isi Kuisioner - Manrisk')
@section('content')
{{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data formValidation', 'autocomplete' => 'off', 'files' => true]) }}
<div class="card card-success">
    <div id="isikuisioner-manrisk" class="card-body">
        {{ Form::fgSelect('Periode', 'periode', to_dropdown($periode), $isikuisioner->periode, ['class' => 'form-control col-md-5'], null, true) }}
        {{ Form::fgSelect('Nama Anak Perusahaan', 'nama_perusahaan', to_dropdown($company_name), $isikuisioner->nama_perusahaan, ['class' => 'form-control col-md-5'], null, true) }}
        {{ Form::fgText('Modal Inti', 'modal_inti', $isikuisioner->modal_inti, ['class' => 'form-control col-md-5 currency'], null, 'text', true) }}
        {{ Form::fgText('Nama Pengisi Kuisioner', 'user', $isikuisioner->user, ['class' => 'form-control col-md-5'], null, 'text', true) }}
        {{ Form::hidden('status_kuisioner', '1') }}
        {{ Form::hidden('status', '1') }}

        <br>

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
                    @if($title == 'create')
                        <td>{{ Form::fgSelect2('jawaban[]', to_dropdown($jawaban), $isikuisioner->jawaban, ['class' => 'form-control inputValidation'], null, true) }}</td>
                        <td>{!! Form::file('file[]', ['class' => 'form-control']) !!}</td>
                        <td>{{ Form::fgText2('description[]', $isikuisioner->description, ['class' => 'form-control','cols' => '20', 'rows' => '7'], null, 'textarea', true) }}</td>
                    @else
                        @foreach($data_penilaian->where('id_pertanyaan_detail', $vd->id) as $v2)
                            <td>{{ Form::fgSelect2('jawaban[]', to_dropdown($jawaban), $v2->jawaban, ['class' => 'form-control'], null, true) }}</td>
                            <td>
                                @isset($v2->file)
                                    <a href="{{ asset('laporan_files/' . $v2->file) }}" alt="file" width="500" height="200" style="margin-top: 0%" target="_blank">{{ $v2->file }}</a>
                                @endisset
                                <div style="margin-bottom: 5%">
                                    {{ Form::hidden($file_jawaban, $v2->file) }}
                                    {!! Form::file($file_jawaban, ['class' => 'form-control', 'multiple']) !!}
                                </div>
                            </td>
                            <td>{{ Form::fgText2('description[]', $v2->description, ['class' => 'form-control','cols' => '20', 'rows' => '7'], null, 'textarea', true) }}</td>
                        @endforeach
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        @endforeach
    </div>

    <div class="card-footer clearfix">
        {{ Form::fgFormButton('isikuisioner-manrisk', $segment) }}
    </div>
</div>
{{ Form::close() }}
@endsection