@extends('layouts.app')
@section('title', 'Isi Kuisioner - Manrisk')
@section('content')
@include('isikuisioner::manrisk.filter')
@if(count($data))
<div class="card card-success">
    <div class="card-body">
        <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
            <thead>
                <tr>
                    <th>{{ __('label.action') }}</th>
                    <th>Nama Perusahaan</th>
                    <th>Pengisi Kuisioner</th>
                    <th>Periode</th>
                    <!-- <th>File</th> -->
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $d)
                <tr>
                    <td>
                        @if($d->status == 2)
                        {!! Html::linkShow('isikuisioner-manrisk', ['id' => $d->id, 'label' => $d->periode !== '-' ? $periode[$d->periode] : $d->periode]) !!}
                        @else
                        {!! Html::linkResource('isikuisioner-manrisk', ['id' => $d->id, 'label' => $d->periode !== '-' ? $periode[$d->periode] : $d->periode]) !!}
                        @endif
                    </td>
                    <td>{{ $d->get_company_name->company_name }}</td>
                    <td style="width: 15%">{{ $d->user }}</td>
                    <td>{{ $d->periode !== '-' ? $periode[$d->periode] : $d->periode }} - {{ substr($d->created_at,0,4) }}</td>
                    <!-- <td style="width: 20%;"><a href="{{ asset('laporan_files/' . $d->file) }}" target="_blank">{{ $d->file }}</td> -->
                    <td>{{ $d->created_at }}</td>
                    <td>
                        @if($d->status == 1)
                        <span class="badge bg-warning">Draft</span>
                    @elseif($d->status == 2)
                        <span class="badge bg-success">Approved</span>
                    @else
                        <span class="badge bg-danger">Reject</span>
                    @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="row">
            <div class="col-6">
                {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('isikuisioner-manrisk'))->links() }}
            </div>

            <div class="col-6 text-right">
                {!! Html::linkCreate('isikuisioner-manrisk') !!}
            </div>
        </div>
    </div>
</div>
@else
<div class="alert alert-warning">
    {!! trans('label.no_data_with_link', ['label' => 'Isi Kuisioner - Manrisk', 'uri' => route('isikuisioner-manrisk.create')]) !!}
</div>
@endif
@endsection