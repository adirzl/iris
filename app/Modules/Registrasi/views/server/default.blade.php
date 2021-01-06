@extends('layouts.app')
@section('title', 'Registrasi - Server')
@section('content')
    @include('registrasi::server.filter')
    @if(count($data))
        <div class="col-md-12 text-right mb-3">
            <a href="{{ url('registrasi-server/export?type=xls') }}" class="btn btn-success export-file">
                <i class="fa fa-file-excel"></i> {{ __('button.export', ['label' => 'XLS']) }}
            </a>&nbsp;
            <a href="{{ url('registrasi-server/export?type=pdf') }}" class="btn btn-danger export-file">
                <i class="fa fa-file-pdf"></i> {{ __('button.export', ['label' => 'PDF']) }}
            </a>
        </div>

        <div class="card card-success">
            <div class="card-body">
                <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                    <thead>
                    <tr>
                        <th>{{ __('label.action') }}</th>
                        <th>IP Address</th>
                        <th>Nama</th>
                        <th>Hash Key</th>
                        <th>Server Environment</th>
                        <th>Blacklist</th>
                        <th>Koneksi UIM API</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>{!! Html::linkUpdateDelete('registrasi-server', ['id' => $d->id, 'label' => $d->ip_address . ' - ' . $d->nama]) !!}</td>
                            <td>{{ $d->ip_address }}</td>
                            <td>{{ $d->nama }}</td>
                            <td>{{ $d->hash_key }}</td>
                            <td>{{ $environment[$d->environment] }}</td>
                            <td>{{ $bool_decision[$d->blacklist] }}</td>
                            <td>{{ $environment[$d->koneksi] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-6">
                        {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('registrasi-server'))->links() }}
                    </div>

                    <div class="col-6 text-right">
                        {!! Html::linkCreate('registrasi-server') !!}
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            {!! trans('label.no_data_with_link', ['label' => 'Registrasi - Server', 'uri' => route('registrasi-server.create')]) !!}
        </div>
    @endif
@endsection