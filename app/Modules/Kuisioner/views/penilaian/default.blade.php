@extends('layouts.app')
@section('title', 'Kuisioner - Penilaian')
@section('content')
@include('kuisioner::penilaian.filter')
@if(count($data))
<div class="card card-success">
    <div class="card-body">
        <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
            <thead>
                <tr>
                    <th>{{ __('label.action') }}</th>
                    <th>Nama Perusahaan</th>
                    <th>User</th>
                    <th>Periode</th>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $d)
                <tr>
                    <td>
                        {!! Html::linkShow('kuisioner-penilaian', ['id' => $d->id, 'label' =>$d->get_company_name->company_name . ' - Triwulan ' . $d->periode . ' - ' . substr($d->created_at,0,4) ]) !!}  
                    </td>
                    <td>{{ $d->get_company_name->company_name }}</td>
                    <td>{{ $d->user }}</td>
                    <td>{{ $d->periode !== '-' ? $periode[$d->periode] : $d->periode }} - {{ substr($d->created_at,0,4) }}</td>
                    <td>{{ $d->created_at }}</td>
                    <td><span class="badge bg-{{ $d->status_kuisioner == 1 ? 'primary' : 'success'}}">{{ $d->status_kuisioner !== '-' ? $status_kuisioner[$d->status_kuisioner] : $d->status_kuisioner }}</span></td>
                    <td>
                        @if($d->status == 1)
                        <span class="badge bg-warning">Draft</span>
                    @elseif($d->status == 2)
                        <span class="badge bg-success">Approved</span>
                    @else
                        <span class="badge bg-danger">Reject</span>
                    @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="row">
            <div class="col-6">
                {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('kuisioner-penilaian'))->links() }}
            </div>
        </div>
    </div>
</div>
@else
<div class="alert alert-warning">
    Data Belum Tersedia, LJK Belum Mengisi
</div>
@endif
@endsection