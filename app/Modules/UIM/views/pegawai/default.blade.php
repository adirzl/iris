@extends('layouts.app')
@section('title', 'Pegawai (UIM)')
@section('content')
    <div class="alert alert-info">
        {!! __('message.synchronized_data_only') !!}
    </div>

    @include('uim::pegawai.filter')

    @if(count($data))
        <div class="col-md-12 text-right mb-3">
            <a href="{{ url('pegawai-uim/export?type=xls') }}" class="btn btn-success export-file">
                <i class="fa fa-file-excel"></i> {{ __('button.export', ['label' => 'XLS']) }}
            </a>&nbsp;
            <a href="{{ url('pegawai-uim/export?type=pdf') }}" class="btn btn-danger export-file">
                <i class="fa fa-file-pdf"></i> {{ __('button.export', ['label' => 'PDF']) }}
            </a>
        </div>

        <div class="card card-success">
            <div class="card-body">
                <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                    <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Unit Kerja</th>
                        <th>Penempatan</th>
                        <th>Jabatan</th>
                        <th>Grade</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>{{ $d->userid }}</td>
                            <td>{{ $d->nama }}</td>
                            <td>{{ $d->nip }}</td>
                            <td>{{ isset($d->unitKerja) ? $d->unitKerja->nama_cabang : '-' }}</td>
                            <td>{{ $d->nama_penempatan }}</td>
                            <td>{{ $d->nama_jabatan }}</td>
                            <td>{{ $d->nama_grade }}</td>
                            <td>{{ $d->status_karyawan }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-12">
                        {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('pegawai-uim'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            {!! trans('label.no_data', ['label' => 'Pegawai (UIM)']) !!}
        </div>
    @endif
@endsection