@extends('layouts.app')
@section('title', 'Evaluasi')
@section('content')
    {{-- @include('opsi::filter') --}}
    @if(count($data))
        <div class="card card-success">
            <div class="card-body">
                <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                    <thead>
                    <tr>
                        <th>{{ __('label.action') }}</th>
                        <th>Judul Riset</th>
                        <th>Unit Kerja Penilai</th>
                        <th>Created at</th>
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
                                            'url' => 'evaluasi.show', 'permission' => 'show evaluasi', 'attributes' => [
                                                'rel' => 'content', 'title' => __('label.show_message', ['label' => $d->risettitle])
                                            ], 'label' => __('label.show_message', ['label' => $d->risettitle]),
                                        ],
                                    ];
                                @endphp
                                {!! Html::linkActions($actions, $d->id) !!}
                            </td>
                            <td>{{ $d->risettitle }}</td>
                            <td>{{ $d->unitkerja->nama }}</td>
                            <td>{{ $d->created_at }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-6">
                        {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('requestfile'))->links() }}
                    </div>

                    <div class="col-6 text-right">
                        {!! Html::linkCreate('requestfile') !!}
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            {!! trans('label.no_data_with_link', ['label' => 'Request File', 'uri' => route('requestfile.create')]) !!}
        </div>
    @endif
@endsection
