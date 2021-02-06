@extends('layouts.app')
@section('title', 'Dokumen - Tipe dan Nama')
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
                            <th>List Tipe</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>
                                {!! Html::linkDokumen('dokumen-filetype', ['id' => $d->unitkerja_kode, 'label' => $d->nama]) !!}
                            </td>
                            <td>{{ $d->nama }}</td>
                            <td>
                                @include('Dokumen::FileType.modal')
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-6">
                        {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('dokumen-filetype'))->links() }}
                    </div>

                    <div class="col-6 text-right">
                        {!! Html::linkCreate('dokumen-filetype') !!}
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            {!! trans('label.no_data_with_link', ['label' => 'Dokumen - Tipe dan Nama', 'uri' => route('dokumen-filetype.create')]) !!}
        </div>
    @endif
@endsection
