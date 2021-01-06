@extends('layouts.app')
@section('title', 'Kelola - Artikel')
@section('content')
    @include('kelola::artikel.filter')
    @if(count($data))
        <div class="card card-success">
            <div class="card-body">
                <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                    <thead>
                    <tr>
                        <th>{{ __('label.action') }}</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>File</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>
                                {!! Html::linkResource('kelola-artikel', ['id' => $d->id, 'label' => $d->title]) !!}  
                            </td>
                            <td>{{ $d->title }}</td>
                            <td>{{ $d->description }}</td>
                            <td><img src="{{ asset('artikel/' . $d->image) }}" alt="image" width="200" height="100" style="margin-top: 0%"></td>
                            <td><a href="{{ asset('artikel_files/' . $d->file) }}" target="_blank">{{ $d->file }}</a></td>
                            <td><span class="badge bg-{{ $d->status == 1 ? 'success' : 'danger'}}">{{ $d->status !== '-' ? $status_artikel[$d->status] : $d->status }}</span></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-6">
                        {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('kelola-artikel'))->links() }}
                    </div>

                    <div class="col-6 text-right">
                        {!! Html::linkCreate('kelola-artikel') !!}
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            {!! trans('label.no_data_with_link', ['label' => 'Kelola - Artikel', 'uri' => route('kelola-artikel.create')]) !!}
        </div>
    @endif
@endsection