@extends('layouts.app')
@section('title', 'Registrasi - Aplikasi')
@section('content')
    @include('registrasi::aplikasi.filter')
    @if(count($data))
        <div class="col-md-12 text-right mb-3">
            <a href="{{ url('registrasi-aplikasi/export?type=xls') }}" class="btn btn-success export-file">
                <i class="fa fa-file-excel"></i> {{ __('button.export', ['label' => 'XLS']) }}
            </a>&nbsp;
            <a href="{{ url('registrasi-aplikasi/export?type=pdf') }}" class="btn btn-danger export-file">
                <i class="fa fa-file-pdf"></i> {{ __('button.export', ['label' => 'PDF']) }}
            </a>
        </div>

        <div class="card card-success">
            <div class="card-body">
                <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                    <thead>
                    <tr>
                        <th>{{ __('label.action') }}</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Akses</th>
                        <th>Otentikasi User</th>
                        <th>Sinkronisasi</th>
                        <th>Timestamp</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>
                                @php
                                    $actions = null;
                                    $actions = [
                                        [
                                            'url' => 'registrasi-aplikasi.edit', 'permission' => 'edit registrasi-aplikasi', 'attributes' => [
                                                'rel' => 'action', 'title' => __('label.update_message', ['label' => $d->nama])
                                            ], 'label' => __('label.update_message', ['label' => $d->nama]),
                                        ],
                                        [
                                            'url' => 'registrasi-aplikasi.matriks', 'permission' => 'matriks registrasi-aplikasi', 'attributes' => [
                                                'rel' => 'download-action', 'title' => 'Export Matriks `' . $d->nama . '`'
                                            ], 'label' => 'Export Matriks `' . $d->nama . '`',
                                        ],
                                    ];

                                    if (!$d->sinkronisasi) {
                                        $actions[] = [
                                            'url' => 'registrasi-aplikasi.sinkronisasi', 'permission' => 'sinkronisasi registrasi-aplikasi', 'attributes' => [
                                                'rel' => 'post-action', 'title' => 'Sinkronisasi `' . $d->nama . '`'
                                            ], 'label' => 'Sinkronisasi `' . $d->nama . '`',
                                        ];
                                    }
                                @endphp
                                {!! Html::linkActions($actions, $d->id) !!}    
                            </td>
                            <td>{{ $d->nama }}</td>
                            <td>{{ $d->alamat }}</td>
                            <td>{{ $d->akses !== '-' ? $akses_aplikasi[$d->akses] : $d->akses }}</td>
                            <td>{{ !is_null($d->otentikasi_user) ? $otentikasi_user[$d->otentikasi_user] : '-' }}</td>
                            <td>{{ $bool_decision[$d->sinkronisasi] }}</td>
                            <td>{{ \Carbon\Carbon::parse($d->created_at)->eq($d->update_at) ? format_date($d->created_at, '%d/%m/%Y %H:%M:%S') : format_date($d->updated_at, '%d/%m/%Y %H:%M:%S') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-6">
                        {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('registrasi-aplikasi'))->links() }}
                    </div>

                    <div class="col-6 text-right">
                        {!! Html::linkCreate('registrasi-aplikasi') !!}
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            {!! trans('label.no_data_with_link', ['label' => 'Registrasi - Aplikasi', 'uri' => route('registrasi-aplikasi.create')]) !!}
        </div>
    @endif
@endsection