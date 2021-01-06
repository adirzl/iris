@extends('layouts.app')
@section('title', 'Sinkronisasi - Pegawai')
@section('content')
    @include('sinkronisasi::pegawai.filter')
    @if(count($data))
        <div class="col-md-12 text-right mb-3">
            <a href="{{ url('sinkronisasi-pegawai/export?type=xls') }}" class="btn btn-success export-file">
                <i class="fa fa-file-excel"></i> {{ __('button.export', ['label' => 'XLS']) }}
            </a>&nbsp;
            <a href="{{ url('sinkronisasi-pegawai/export?type=pdf') }}" class="btn btn-danger export-file">
                <i class="fa fa-file-pdf"></i> {{ __('button.export', ['label' => 'PDF']) }}
            </a>
        </div>

        <div class="card card-success">
            {{ Form::open(['route' => 'sinkronisasi-pegawai.send', 'method' => 'post', 'class' => 'form-horizontal form-send']) }}
                <div class="card-body">
                    <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                        <thead>
                        <tr>
                            <th>
                                @if($data->where('sinkronisasi', 0)->count())
                                {{ Form::checkbox('check_all', 1, false) }}
                                @else
                                -
                                @endif
                            </th>
                            <th>User ID</th>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>Jabatan</th>
                            <th>Penempatan</th>
                            <th>Tgl. Sinkronisasi</th>
                            <th>Sinkronisasi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $d)
                            <tr>
                                <td>
                                    @if($data->where('sinkronisasi', 0)->count())
                                    {{ Form::checkbox('check[]', $d->id, false) }}
                                    @else
                                    <i class="fas fa-check-square"></i>
                                    @endif
                                </td>
                                <td>{{ $d->userid }}</td>
                                <td>{{ $d->nama }}</td>
                                <td>{{ $d->nip }}</td>
                                <td>{{ $d->nama_jabatan }}</td>
                                <td>{{ $d->nama_penempatan }}</td>
                                <td>{{ format_date($d->tgl_sinkronisasi, '%d/%m/%Y') }}</td>
                                <td>{{ $bool_decision[$d->sinkronisasi] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">
                    <div class="row">
                        <div class="col-{{ $data->where('sinkronisasi', 0)->count() ? '6' : '12' }}">
                            {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('sinkronisasi-pegawai'))->links() }}
                        </div>

                        @if($data->where('sinkronisasi', 0)->count())
                        <div class="col-6 text-right">
                            <button class="btn btn-primary" id="send-all">
                                <i class="fas fa-paper-plane"></i> Kirim Semua
                            </button>&nbsp;
                            <button class="btn btn-info" id="send-selected">
                                <i class="fas fa-share-square"></i> Kirim yang dipilih
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            {{ Form::close()}}
        </div>
    @else
        <div class="alert alert-warning">
            {!! trans('label.no_data', ['label' => 'Sinkronisasi - Pegawai']) !!}
        </div>
    @endif
@endsection