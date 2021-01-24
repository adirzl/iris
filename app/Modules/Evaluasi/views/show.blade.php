@extends('layouts.app')
@section('title', 'Show Evaluasi')
@section('content')
    <div class="card card-success">
        <div class="card-body">
            {{ Form::fgText('Judul Riset', 'user_id', $data->risettitle, ['class' => 'form-control', 'disabled'], null, 'text', true) }}
            {{ Form::fgText('Unit Kerja Penilai', 'filearchive_id', $data->unitkerja->nama, ['class' => 'form-control', 'disabled'], null, 'text', true) }}
            {{ Form::fgText('Seberapa puaskah anda terhadap kualitas riset?', 'risetquality', $data->risetquality, ['class' => 'form-control', 'disabled'], null, 'text', true) }}

            <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                <thead>
                    <tr>
                        <th>Aspek yang perlu ditingkatkan</th>
                        <th>Penjelasan dan saran</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($data->evaluasidetail))
                        @foreach($data->evaluasidetail as $item)
                            <tr>
                                <td>{{ $item->aspect }}</td>
                                <td>{{ $item->description }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="2">No Record(s) found</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ Form::fgFormButton('evaluasi', 'show') }}
        </div>
    </div>
@endsection
