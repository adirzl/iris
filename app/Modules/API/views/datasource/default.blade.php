@extends('layouts.app')
@section('title', 'Datasource')
@section('content')
    @include('api::datasource.filter')
    @if(count($data))
        <div class="card card-success">
            <div class="card-body">
                <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                    <thead>
                    <tr>
                        <th>{{ __('label.action') }}</th>
                        <th>Nama</th>
                        <th>Environment</th>
                        <th>Dialect</th>
                        <th>Properties</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>{!! Html::linkUpdateDelete('datasource', ['id' => $d->id, 'label' => $d->nama]) !!}</td>
                            <td>{{ $d->nama }}</td>
                            <td>{{ $environment[$d->environment] }}</td>
                            <td>{{ $dialect[$d->dialect] }}</td>
                            <td>{!! collect(json_decode($d->properties, true))->map(function ($item, $key) { return '<strong>'. $key . '</strong>: ' . $item; })->implode('<br>') !!}</td>
                            <td>{{ $status[$d->status] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-6">
                        {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('datasource'))->links() }}
                    </div>

                    <div class="col-6 text-right">
                        {!! Html::linkCreate('datasource') !!}
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            {!! trans('label.no_data_with_link', ['label' => 'Datasource', 'uri' => route('datasource.create')]) !!}
        </div>
    @endif
@endsection