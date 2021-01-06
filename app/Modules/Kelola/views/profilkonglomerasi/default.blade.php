@extends('layouts.app')
@section('title', 'Kelola - Profil Konglomerasi')
@section('content')
    <!-- @include('kelola::profilkonglomerasi.filter') -->
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
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>
                                {!! Html::linkUpdateShow('kelola-profilkonglomerasi', ['id' => $d->id, 'label' => $d->title]) !!}  
                            </td>
                            <td>{{ $d->title }}</td>
                            <td>{{ $d->description }}</td>
                            <td><img src="{{ asset('profil/' . $d->image) }}" alt="logo" width="200" height="100" style="margin-top: 0%"></td>
                            <td><span class="badge bg-primary">{{ $d->status !== '-' ? $status_profil[$d->status] : $d->status }}</span></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-6">
                        {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('kelola-profilkonglomerasi'))->links() }}
                    </div>

                    {{-- <div class="col-6 text-right">
                        {!! Html::linkCreate('kelola-profilkonglomerasi') !!}
                    </div> --}}
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            {!! trans('label.no_data_with_link', ['label' => 'Kelola - Profil Konglomerasi', 'uri' => route('kelola-profilkonglomerasi.create')]) !!}
        </div>
    @endif
@endsection