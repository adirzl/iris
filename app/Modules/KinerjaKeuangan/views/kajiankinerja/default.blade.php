@extends('layouts.app')
@section('title', 'RKAT Audit')
@section('content')
    @include('PengawasanAudit::rkat.filter')
    @if(count($data))
        <div class="card card-success">
            <div class="card-body">
                <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                    <thead>
                    <tr>
                        <th>{{ __('label.action') }}</th>
                        <th>Lembaga Jasa Keuangan</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>
                                {!! Html::linkResource('rkat-audit', ['id' => $d->id, 'label' => $ljk[$d->ljk]]) !!}  
                            </td>
                            <td>{{$ljk[$d->ljk]}}</td>
                            <td>-</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-6">
                        {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('rkat-audit'))->links() }}
                    </div>

                    <div class="col-6 text-right">
                        {!! Html::linkCreate('rkat-audit') !!}
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            {!! trans('label.no_data_with_link', ['label' => 'RKAT - Audit', 'uri' => route('rkat-audit.create')]) !!}
        </div>
    @endif
@endsection