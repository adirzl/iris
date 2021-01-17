@extends('layouts.app')
@section('title', 'Request File')
@section('content')
    {{-- @include('opsi::filter') --}}
    @if(count($data))
        <div class="card card-success">
            <div class="card-body">
                <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                    <thead>
                    <tr>
                        <th>{{ __('label.action') }}</th>
                        <th>User</th>
                        <th>File</th>
                        <th>Description</th>
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
                                            'url' => 'requestfile.approval', 'permission' => 'approval requestfile', 'attributes' => [
                                                'rel' => 'content', 'title' => __('label.approval_message', ['label' => $d->created_at])
                                            ], 'label' => __('label.approval_message', ['label' => $d->created_at]),
                                        ],
                                    ];
                                @endphp
                                {!! Html::linkActions($actions, $d->id) !!}
                            </td>
                            <td>{{ $d->user_id }}</td>
                            <td>{{ $d->filearchive_id }}</td>
                            <td>{{ $d->description }}</td>
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
