@extends('layouts.app')
@section('title', 'Kelola - Konten')
@section('content')
    @if (count($data))
        <div class="card card-success">
            <div class="card-body">
                <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                    <thead>
                        <tr>
                            <th>{{ __('label.action') }}</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $d)
                            <tr>
                                <td>
                                    {!! Html::linkUpdateShow('kelola-konten', ['id' => $d->id, 'label' => $d->title]) !!}
                                </td>
                                <td>{{ $d->title }}</td>
                                <td>{{ $d->description }}</td>
                                <td>
                                    @if ($d->status != 2)
                                        <img src="{{ asset('konten/' . $d->image) }}" alt="logo" width="200" height="100"
                                            style="margin-top: 0%">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <span
                                        class="badge bg-primary">{{ $d->status !== '-' ? $status_konten[$d->status] : $d->status }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-6">
                        {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('kelola-konten'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            {!! trans('label.no_data_with_link', ['label' => 'Kelola - Konten', 'uri' => route('kelola-konten.create')]) !!}
        </div>
    @endif
@endsection
