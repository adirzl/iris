@extends('layouts.app')
@section('title', 'Sinkronisasi - Ubah Limit')
@section('content')
    @include('sinkronisasi::ubah-limit.filter')
    @if(count($data))
        <div class="col-md-12 text-right mb-3">
            <a href="{{ url('sinkronisasi-limit/export?type=xls') }}" class="btn btn-success export-file">
                <i class="fa fa-file-excel"></i> {{ __('button.export', ['label' => 'XLS']) }}
            </a>&nbsp;
            <a href="{{ url('sinkronisasi-limit/export?type=pdf') }}" class="btn btn-danger export-file">
                <i class="fa fa-file-pdf"></i> {{ __('button.export', ['label' => 'PDF']) }}
            </a>
        </div>

        <div class="card card-success">
            {{ Form::open(['route' => 'sinkronisasi-limit.send', 'method' => 'post', 'class' => 'form-horizontal form-send']) }}
                <div class="card-body">
                    <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                        <thead>
                        <tr>
                            <th>{{ Form::checkbox('check_all', 1, false) }}</th>
                            <th>User ID</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Aplikasi</th>
                            <th>Kode Cabang</th>
                            <th>Limit Oto Kredit</th>
                            <th>Limit Oto Debit</th>
                            <th>Grup Limit</th>
                            <th>Limit Oto Kredit Default</th>
                            <th>Limit Oto Debit Default</th>
                            <th>Tgl. Sinkronisasi</th>
                            <th>Sinkronisasi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $d)
                            <tr>
                                <td>
                                    @if($d->idaplikasi == 3 && $d->sinkronisasi == 0)
                                    {{ Form::checkbox('check[]', $d->id, false) }}
                                    @else
                                    <i class="fas fa-check-square"></i>
                                    @endif
                                </td>
                                <td>{{ $d->userid }}</td>
                                <td>{{ $d->nama }}</td>
                                <td>{{ $d->jabatan->jabatan }}</td>
                                <td>{{ $d->aplikasi }}</td>
                                <td>{{ $d->kode_cabang }}</td>
                                <td>{{ $d->limit_oto_kredit }}</td>
                                <td>{{ $d->limit_oto_debit }}</td>
                                <td>{{ $d->grup_limit }}</td>
                                <td>{{ $d->limit_oto_kredit_default }}</td>
                                <td>{{ $d->limit_oto_debit_default }}</td>
                                <td>{{ format_date($d->tgl_sinkronisasi, '%d/%m/%Y') }}</td>
                                <td>{{ $bool_decision[$d->sinkronisasi] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">
                    <div class="row">
                        <div class="col-6">
                            {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('sinkronisasi-pegawai'))->links() }}
                        </div>

                        <div class="col-6 text-right">
                            <button class="btn btn-primary" id="send-all">
                                <i class="fas fa-paper-plane"></i> Kirim Semua
                            </button>&nbsp;
                            <button class="btn btn-info" id="send-selected">
                                <i class="fas fa-share-square"></i> Kirim yang dipilih
                            </button>
                        </div>
                    </div>
                </div>
            {{ Form::close()}}
        </div>
    @else
        <div class="alert alert-warning">
            {!! trans('label.no_data', ['label' => 'Sinkronisasi - Ubah Limit tanggal ' . now()->yesterday()->format('d/m/Y')]) !!}
        </div>
    @endif
@endsection