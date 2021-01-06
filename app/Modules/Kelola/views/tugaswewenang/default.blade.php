@extends('layouts.app')
@section('title', 'Kelola - Tugas dan Wewenang')
@section('content')
    @include('kelola::tugaswewenang.filter')
    @if(count($data))
        <div class="card card-success">
            <div class="card-body">
                <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                    <thead>
                    <tr>
                        <th>{{ __('label.action') }}</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Status Data</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>
                                {!! Html::linkResource('kelola-tugaswewenang', ['id' => $d->id, 'label' => $d->title]) !!}  
                            </td>
                            <td>{{ $d->title }}</td>
                            <td>{{ $d->description }}</td>
                            <td><span class="badge bg-{{ $d->status_data == 1 ? 'warning' : 'info'}}">{{ $d->status_data !== '-' ? $status_data[$d->status_data] : $d->status_data }}</span></td>
                            <td><span class="badge bg-{{ $d->status == 1 ? 'success' : 'danger'}}">{{ $d->status !== '-' ? $status[$d->status] : $d->status }}</span></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-6">
                        {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('kelola-tugaswewenang'))->links() }}
                    </div>

                    <div class="col-6 text-right">
                        {!! Html::linkCreate('kelola-tugaswewenang') !!}
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            {!! trans('label.no_data_with_link', ['label' => 'Kelola - Tugas dan Wewenang', 'uri' => route('kelola-tugaswewenang.create')]) !!}
        </div>
    @endif
@endsection