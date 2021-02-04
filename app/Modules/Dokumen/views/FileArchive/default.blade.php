@extends('layouts.app')
@section('title', 'Dokumen - Upload')
@section('content')
    @include('kelola::banner.filter')
    @if(count($data))
        <div class="card card-success">
            <div class="card-body">
                <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                    <thead>
                    <tr>
                        <th>{{ __('label.action') }}</th>
                        <th>Unit Kerja</th>
                        <th>Type</th>
                        <th>File</th>
                        <th>Versi</th>
                        <th>Status</th>
                        <th>Date Create</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>
                                {!! Html::linkDokumenUpload('dokumen-filearchive', ['id' => $d->id, 'label' => $d->unitkerja->nama.' - '.$d->file_type->name,'status'=>$d->status]) !!}
                            </td>
                            <td>{{ $d->unitkerja->nama }}</td>
                            <td>{{ $d->file_type->name }}</td>
                            <td>
                            <a href="{{asset($d->path)}}">
                                {{ $d->label }}
                            </a>
                            </td>
                            <td>{{ $d->version }}</td>
                            <td>{{ $status[$d->status] }}</td>
                            <td>{{ $d->created_at }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-6">
                        {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('dokumen-filearchive'))->links() }}
                    </div>

                    <div class="col-6 text-right">
                        {!! Html::linkCreate('dokumen-filearchive') !!}
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            {!! trans('label.no_data_with_link', ['label' => 'Dokumen - Upload', 'uri' => route('dokumen-filearchive.create')]) !!}
        </div>
    @endif
@endsection
