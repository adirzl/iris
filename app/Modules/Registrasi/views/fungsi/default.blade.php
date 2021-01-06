@extends('layouts.app')
@section('title', 'Registrasi - Fungsi')
@section('content')
    @include('registrasi::fungsi.filter')
    @if(count($data))
        <div class="col-md-12 text-right mb-3">
            <a href="{{ url('registrasi-aplikasi-fungsi/export?type=xls') }}" class="btn btn-success export-file">
                <i class="fa fa-file-excel"></i> {{ __('button.export', ['label' => 'XLS']) }}
            </a>&nbsp;
            <a href="{{ url('registrasi-aplikasi-fungsi/export?type=pdf') }}" class="btn btn-danger export-file">
                <i class="fa fa-file-pdf"></i> {{ __('button.export', ['label' => 'PDF']) }}
            </a>
        </div>

        <div class="card card-success">
            <div class="card-body">
                <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                    <thead>
                    <tr>
                        <th>{{ __('label.action') }}</th>
                        <th>Aplikasi</th>
                        <th>Fungsi</th>
                        <th>Menu</th>
                        <th>Fungsi Akses 1</th>
                        <th>Fungsi Akses 2</th>
                        <th>Status</th>
                        <th>Sinkronisasi</th>
                        <th>Timestamp</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>
                                @if(!$d->sinkronisasi)
                                @php
                                    $actions = null;
                                    $actions = [
                                        [
                                            'url' => 'registrasi-aplikasi-fungsi.edit', 'permission' => 'edit registrasi-aplikasi-fungsi', 'attributes' => [
                                                'rel' => 'action', 'title' => __('label.update_message', ['label' => $d->nama])
                                            ], 'label' => __('label.update_message', ['label' => $d->nama]),
                                        ],
                                    ];

                                    if (!$d->sinkronisasi) {
                                        $actions[] = [
                                            'url' => 'registrasi-aplikasi-fungsi.sinkronisasi', 'permission' => 'sinkronisasi registrasi-aplikasi-fungsi', 'attributes' => [
                                                'rel' => 'post-action', 'title' => 'Sinkronisasi `' . $d->nama . '`'
                                            ], 'label' => 'Sinkronisasi `' . $d->nama . '`',
                                        ];
                                    }
                                @endphp
                                {!! Html::linkActions($actions, $d->id) !!} 
                                @else
                                {!! Html::linkUpdate('registrasi-aplikasi-fungsi', $d->id, $d->nama) !!}
                                @endif
                            </td>
                            <td>{{ $d->aplikasi->nama }}</td>
                            <td>{{ $d->nama }}</td>
                            <td>{{ $d->menu }}</td>
                            <td>{{ akses_aplikasi($d->akses1) }}</td>
                            <td>{{ akses_aplikasi($d->akses2) }}</td>
                            <td>{{ $status[$d->status] }}</td>
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
                        {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('registrasi-aplikasi-fungsi'))->links() }}
                    </div>

                    <div class="col-6 text-right">
                        {!! Html::linkCreate('registrasi-aplikasi-fungsi') !!}
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            {!! trans('label.no_data_with_link', ['label' => 'Registrasi - Fungsi', 'uri' => route('registrasi-aplikasi-fungsi.create')]) !!}
        </div>
    @endif
@endsection