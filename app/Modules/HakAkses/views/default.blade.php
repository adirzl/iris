@extends('layouts.app')
@section('title', 'Hak Akses')
@section('content')
    @include('hakakses::filter')
    @if(count($data))
        <div class="card card-success">
            <div class="card-body">
                <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                    <thead>
                    <tr>
                        <th>{{ __('label.action') }}</th>
                        <th>Hak Akses</th>
                        <th>Menu</th>
                        <th>Pengelolaan</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>
                                @php
                                    $actions = null;
                                    $actions[] = ['url' => 'hak-akses.edit', 'permission' => 'edit hak-akses', 'attributes' => ['rel' => 'action', 'title' => __('label.update_message', ['label' => $d->name])], 'label' => __('label.update_message', ['label' => $d->name])];
                                    if ($d->modules->count() == 0 && $d->permissions->count() == 0) {
                                        array_push($actions, [
                                            'url' => 'hak-akses.destroy', 'permission' => 'destroy hak-akses', 'attributes' => [
                                                'rel' => 'delete',
                                                'title' => __('label.delete_message', ['label' => $d->name])
                                            ], 'label' => __('label.delete_message', ['label' => $d->name])
                                        ]);
                                    }
                                @endphp
                                {!! Html::linkActions($actions, $d->id) !!}
                            </td>
                            <td>{{ $d->name }}</td>
                            <td>{{ $d->modules->implode('label', ', ') }}</td>
                            <td>{{ $d->permissions->implode('name', ', ') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-6">
                        {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('hak-akses'))->links() }}
                    </div>

                    <div class="col-6 text-right">
                        {!! Html::linkCreate('hak-akses') !!}
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            {!! trans('label.no_data_with_link', ['label' => 'Hak Akses', 'uri' => route('hak-akses.create')]) !!}
        </div>
    @endif
@endsection