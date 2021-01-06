@extends('layouts.app')
@section('title', 'Kelola - Company Profile')
@section('content')
    @include('kelola::comprof.filter')
    @if(count($data))
        <div class="card card-success">
            <div class="card-body">
                <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                    <thead>
                    <tr>
                        <th>{{ __('label.action') }}</th>
                        <th>Company Name</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>
                                {!! Html::linkUpdateShow('kelola-comprof', ['id' => $d->id, 'label' => $d->company_name]) !!}  
                            </td>
                            <td>{{ $d->company_name }}</td>
                            <td>{{ $d->description }}</td>
                            <td><img src="{{ asset('comprof/' . $d->image) }}" alt="image" width="200" height="100" style="margin-top: 0%"></td>
                            <td><span class="badge bg-{{ $d->status == 1 ? 'success' : 'danger'}}">{{ $d->status !== '-' ? $status_perusahaan[$d->status] : $d->status }}</span></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-6">
                        {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('kelola-comprof'))->links() }}
                    </div>

                    <div class="col-6 text-right">
                        {!! Html::linkCreate('kelola-comprof') !!}
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            {!! trans('label.no_data_with_link', ['label' => 'Kelola - Company Profile', 'uri' => route('kelola-comprof.create')]) !!}
        </div>
    @endif
@endsection