@extends('layouts.app')
@section('title', 'Kelola - Laporan')
@section('content')
@include('kelola::laporan.filter')
@if(count($data))
<div class="card card-success">
    <div class="card-body">
        <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
            <thead>
                <tr>
                    <th>{{ __('label.action') }}</th>
                    <th>Nama Perusahaan</th>
                    <th>Judul Laporan</th>
                    <th>Description</th>
                    <th>Periode</th>
                    <th>Tahun</th>
                    <th>File</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $d)
                <tr>
                    <td>
                        {!! Html::linkResource('kelola-laporan', ['id' => $d->id, 'label' => $d->title]) !!}
                    </td>
                    <td>{{ $d->get_company_name->company_name }}</td>
                    <td>{{ $d->title }}</td>
                    <td>{{ $d->description }}</td>
                    <td>{{ $d->periode !== '-' ? $bulan[$d->periode] : $d->periode }}</td>
                    <td>{{ $d->tahun }}</td>
                    <td><a href="{{ asset('laporan_files/' . $d->file) }}" target="_blank">{{ $d->file }}</a></td>
                    <td><span class="badge bg-{{ $d->status == 1 ? 'success' : 'danger'}}">{{ $d->status !== '-' ? $status_laporan[$d->status] : $d->status }}</td>
                    {{-- <td><span class="badge bg-{{ $d->status_progres == 3 ? 'success' : 'warning'}}">{{ $d->status_progres !== '-' ? $status_progres[$d->status_progres] : $d->status_progres }}</td> --}}
                    @if($d->status_progres == 1)
                        <td><span class="badge bg-warning">Draft</span></td>
                    @elseif($d->status_progres == 2)
                        <td><span class="badge bg-success">Approved</span></td>
                    @else
                        <td><span class="badge bg-danger">Reject</span></td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="row">
            <div class="col-6">
                {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('kelola-laporan'))->links() }}
            </div>

            <div class="col-6 text-right">
                {!! Html::linkCreate('kelola-laporan') !!}
            </div>
        </div>
    </div>
</div>
@else
<div class="alert alert-warning">
    {!! trans('label.no_data_with_link', ['label' => 'Kelola - Laporan', 'uri' => route('kelola-laporan.create')]) !!}
</div>
@endif
@endsection