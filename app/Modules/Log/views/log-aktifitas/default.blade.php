@extends('layouts.app')
@section('title', 'Log Aktifitas')
@section('content')
    @include('log::log-aktifitas.filter')
    @if(count($data))
        <div class="card card-success">
            <div class="card-body">
                <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                    <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Log</th>
                        <th>User</th>
                        <th>IP Address</th>
                        <th>User Agent</th>
                        <th>Deskripsi</th>
                        <th>Properti</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $d)
                        <tr>
                            <td>{{ $d->created_at }}</td>
                            <td>{{ $d->log_name }}</td>
                            <td>{{ $d->user ? $d->user->nama : '-' }}</td>
                            <td>{{ $d->ip_address }}</td>
                            <td>{{ $d->user_agent }}</td>
                            <td>
                                @php
                                $curlyFirst = strpos($d->description, '{');
                                $curlyEnd = strpos($d->description, '}') + 1;
                                $deskripsi = substr($d->description, 0, $curlyFirst) . ' ' . substr($d->description, $curlyEnd);
                                @endphp
                                {{ $deskripsi }}
                            </td>
                            <td>
                                <a href="#modal-{{ $d->id }}" data-toggle="modal" data-target="#modal-{{ $d->id }}">[Klik untuk melihat properti]</a>
                                @include('log::log-aktifitas.modal')
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-{{ auth()->user()->can('clean log-aktifitas') ? '6' : '12' }}">
                        {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('log-aktifitas'))->links() }}
                    </div>

                    @can('clean log-aktifitas')
                    <div class="col-6 text-right">
                        <a href="{{ route('log-aktifitas.clean') }}" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash"></i> {{ __('button.clean_log') }}
                        </a>
                    </div>
                    @endcan
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            {!! trans('label.no_data', ['label' => 'Log Aktifitas']) !!}
        </div>
    @endif
@endsection