@extends('layouts.app')
@section('title', 'Opsi')
@section('content')
    @include('opsi::filter')
    @if(count($data))
        <div class="card card-success">
            <div class="card-body">
                <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                    <thead>
                    <tr>
                        <th>{{ __('label.action') }}</th>
                        <th>Nama Opsi</th>
                        <th>Opsi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>{!! Html::linkUpdateDelete('opsi', ['id' => $d->id, 'label' => $d->name]) !!}</td>
                            <td>{{ $d->name }}</td>
                            <td>
                                @php($values = $d->optionValues->mapWithKeys(function ($item) { return [$item['key'] => $item['value']]; }))
                                {{ implode(', ', array_values($values->toArray())) }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-6">
                        {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('opsi'))->links() }}
                    </div>

                    <div class="col-6 text-right">
                        {!! Html::linkCreate('opsi') !!}
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            {!! trans('label.no_data_with_link', ['label' => 'Opsi', 'uri' => route('opsi.create')]) !!}
        </div>
    @endif
@endsection