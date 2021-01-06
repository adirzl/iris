@extends('layouts.app')
@section('title', 'Limit Otorisasi')
@section('content')
    @include('limit-otorisasi::filter')
    @if(count($data))
        <div class="card card-success">
            <div class="card-body">
                <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                    <thead>
                    <tr>
                        <th>{{ __('label.action') }}</th>
                        <th>Kode</th>
                        <th>Jabatan</th>
                        <th>Limit Kredit</th>
                        <th>Limit Debit</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>{!! Html::linkUpdateDelete('limit-otorisasi', ['id' => $d->id, 'label' => $d->kode]) !!}</td>
                            <td>{{ $d->kode }}</td>
                            <td>{{ collect($d->jabatan)->map(function ($value, $key) use ($jabatan) { return isset($jabatan[$value]) ? $jabatan[$value] : '-'; })->implode(', ') }} </td>
                            <td>{{ number_format($d->limit_kredit) }}</td>
                            <td>{{ number_format($d->limit_debit) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-6">
                        {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('limit-otorisasi'))->links() }}
                    </div>

                    <div class="col-6 text-right">
                        {!! Html::linkCreate('limit-otorisasi') !!}
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            {!! trans('label.no_data_with_link', ['label' => 'Limit Otorisasi', 'uri' => route('limit-otorisasi.create')]) !!}
        </div>
    @endif
@endsection