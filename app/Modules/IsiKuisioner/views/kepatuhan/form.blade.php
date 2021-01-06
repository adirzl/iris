@php
$segment = request()->segment(2);
$title = 'create'; $method = 'post'; $action = 'isikuisioner-kepatuhan.store';
if ($segment !== 'create' ) { $title = 'edit'; $method = 'put'; $action = ['isikuisioner-kepatuhan.update', $isikuisioner->id]; }
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' Isi Kuisioner - Kepatuhan')
@section('content')
{{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off', 'files' => true]) }}
<div class="card card-success">
    <div id="isikuisioner-kepatuhan" class="card-body">
        {{ Form::fgSelect('Periode', 'periode', to_dropdown($periode), $isikuisioner->periode, ['class' => 'form-control col-md-5'], null, true) }}
        {{ Form::fgSelect('Nama Anak Perusahaan', 'nama_perusahaan', to_dropdown($company_name), $isikuisioner->nama_perusahaan, ['class' => 'form-control col-md-5'], null, true) }}
        {{ Form::fgText('Modal Inti', 'modal_inti', $isikuisioner->modal_inti, ['class' => 'form-control col-md-5 currency'], null, 'text', true) }}
        {{ Form::fgText('Nama Pengisi Kuisioner', 'user', $isikuisioner->user, ['class' => 'form-control col-md-5'], null, 'text', true) }}
        {{ Form::hidden('status_kuisioner', '2') }}
        {{ Form::hidden('status', '1') }}

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
                    @if($title == 'create')
                    <td>
                        {{ Form::hidden('jawaban[]', null) }}
                        {{ Form::fgText2('jawaban[]', 1, null, null, 'radio', true) }}
                    </td>
                    <td>{{ Form::fgText2('description[]', $isikuisioner->description, ['class' => 'form-control','cols' => '10', 'rows' => '5'], null, 'textarea', true) }}</td>
                    @else
                    <td>
                        {{ Form::hidden('jawaban[]', null) }}
                        @foreach($data_penilaian->where('id_pertanyaan_detail', $vd->id) as $v2)
                        {{ Form::fgText2('jawaban[]', true, $a = ($v2->jawaban == 1) ? ['checked'] : null, null, 'radio', true) }}
                        {{-- <center>{{ Form::checkbox('jawaban[]', 1, $a = ($v2->jawaban == 1) ? true : false) }}</center> --}}
                    </td>
                    <td>{{ Form::fgText2('description[]', $v2->description, ['class' => 'form-control','cols' => '10', 'rows' => '5'], null, 'textarea', true) }}</td>
                    @endforeach
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        @endforeach

    </div>

    <div class="card-footer clearfix">
        {{ Form::fgFormButton('isikuisioner-kepatuhan', $segment) }}
    </div>
</div>
{{ Form::close() }}
@endsection