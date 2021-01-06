@extends('layouts.app')
@section('title', 'Jabatan (HCS)')
@section('content')
    <div class="alert alert-info">
        {!! __('message.synchronized_data_only') !!}
    </div>

    @include('hcs::jabatan.filter')

    @if(count($data))
        <div class="col-md-12 text-right mb-3">
            <a href="{{ url('jabatan-hcs/export?type=xls') }}" class="btn btn-success export-file">
                <i class="fa fa-file-excel"></i> {{ __('button.export', ['label' => 'XLS']) }}
            </a>&nbsp;
            <a href="{{ url('jabatan-hcs/export?type=pdf') }}" class="btn btn-danger export-file">
                <i class="fa fa-file-pdf"></i> {{ __('button.export', ['label' => 'PDF']) }}
            </a>
        </div>

        <div class="card card-success">
            <div class="card-body">
                <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                    <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>{{ $d->kode }}</td>
                            <td>{{ $d->nama }}</td>
                            <td>{{ $status[$d->status] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-12">
                        {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('jabatan-hcs'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            {!! trans('label.no_data', ['label' => 'Jabatan (HCS)']) !!}
        </div>
    @endif
@endsection