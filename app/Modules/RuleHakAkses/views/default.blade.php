@extends('layouts.app')
@section('title', 'Rule Hak Akses')
@section('content')
    @include('rule-hak-akses::filter')
    @if(count($data))
        <div class="card card-success">
            <div class="card-body">
                <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                    <thead>
                    <tr>
                        <th>{{ __('label.action') }}</th>
                        <th>Grade</th>
                        <th>Pegawai TI</th>
                        <th>Ditunjuk sebagai Admin SPV TI</th>
                        <th>Ditunjuk sebagai Admin TI</th>
                        <th>Primary Level</th>
                        <th>Secondary Level</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>{!! Html::linkUpdateDelete('rule-hak-akses', ['id' => $d->id, 'label' => $d->level]) !!}</td>
                            <td>{{ !is_null($d->grade) ? collect($d->grade)->map(function ($value, $key) use ($grade) { return isset($grade[$value]) ? $grade[$value] : '-'; })->implode(', ') : '-' }}</td>
                            <td>{{ $bool_decision[$d->pegawai_ti] }}</td>
                            <td>{{ $bool_decision[$d->as_admin_spv] }}</td>
                            <td>{{ $bool_decision[$d->as_admin] }}</td>
                            <td>{{ $level_hakakses[$d->primary_level] }}</td>
                            <td>{{ !is_null($d->secondary_level) ? $level_hakakses[$d->secondary_level] : '-' }}</td> 
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-6">
                        {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('rule-hak-akses'))->links() }}
                    </div>

                    <div class="col-6 text-right">
                        {!! Html::linkCreate('rule-hak-akses') !!}
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            {!! trans('label.no_data_with_link', ['label' => 'Rule Hak Akses', 'uri' => route('rule-hak-akses.create')]) !!}
        </div>
    @endif
@endsection