@extends('layouts.app')
@section('title', 'Log Transaksi')
@section('content')
    @include('api::log-transaksi.filter')
    @if(count($data))
        <div class="card card-success">
            <div class="card-body">
                <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                    <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>IP Address</th>
                        <th>Job Type</th>
                        <th>Job Name</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $d)
                        <tr>
                            <td>{{ $d->tgl_transaksi }}</td>
                            <td>{{ $d->ipaddress }}</td>
                            <td>{{ $d->jobtype }}</td>
                            <td>{{ $d->jobname }}</td>
                            <td>{{ $d->status }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-12">
                        {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('log-transaksi'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            {!! trans('label.no_data', ['label' => 'Log Transaksi']) !!}
        </div>
    @endif
@endsection