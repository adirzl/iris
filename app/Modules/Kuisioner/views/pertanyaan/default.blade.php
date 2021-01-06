@extends('layouts.app')
@section('title', 'Kuisioner - Pertanyaan')
@section('content')
    @include('kuisioner::pertanyaan.filter')
    @if(count($data))
        <div class="card card-success">
            <div class="card-body">
                <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                    <thead>
                    <tr>
                        <th>{{ __('label.action') }}</th>
                        <th>Description</th>
                        <th>Tgl Dibuat</th>
                        <th>Tgl Diubah</th>
                        <th>User</th>
                        <th>Status</th>
                    </tr> 
                    </thead>
                    <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>
                                {!! Html::linkResource('kuisioner-pertanyaan', ['id' => $d->id, 'label' => $d->description]) !!}  
                            </td>
                            <td>{{ $d->description }}</td>
                            <td>{{ $d->created_at }}</td>
                            <td>{{ $d->updated_at }}</td>
                            <td>{{ $d->status_user !== '-' ? $status_user[$d->status_user] : $d->status_user }}</td>
                            <td><span class="badge bg-{{ $d->status == 1 ? 'success' : 'danger'}}">{{ $d->status !== '-' ? $status_pertanyaan[$d->status] : $d->status }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-6">
                        {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('kuisioner-pertanyaan'))->links() }}
                    </div>

                    <div class="col-6 text-right">
                        {!! Html::linkCreate('kuisioner-pertanyaan') !!}
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            {!! trans('label.no_data_with_link', ['label' => 'Kuisioner - Pertanyaan', 'uri' => route('kuisioner-pertanyaan.create')]) !!}
        </div>
    @endif
@endsection