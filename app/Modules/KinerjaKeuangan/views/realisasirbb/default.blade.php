@php
$title = 'create'; $method = 'post'; $action = 'realisasi-rbb.store';
@endphp
@extends('layouts.app')
@section('title', 'Realisasi RBB')
@section('content')
@include('KinerjaKeuangan::realisasirbb.filter')

{{-- notifikasi form validasi --}}
@if ($errors->has('file'))
<span class="invalid-feedback" role="alert">
    <strong>{{ $errors->first('file') }}</strong>
</span>
@endif

{{-- notifikasi sukses --}}
@if ($sukses = Session::get('sukses'))
<div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $sukses }}</strong>
</div>
@endif

<!-- Import Excel -->
<div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        {{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off', 'files' => true]) }}
        <form method="post" action="" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Data</h5>
                </div>
                <div class="modal-body">

                    {{ csrf_field() }} 

                    {{ Form::fgText('Tahun', 'tahun', null, ['class' => 'form-control yearpick', 'placeholder' => 'Tahun'], null, 'text', true) }}
                    {{ Form::fgText('Periode Bulan', 'bulan', null, ['class' => 'form-control monthpick', 'placeholder' => 'Bulan'], null, 'text', true) }}
                    {{-- {{ Form::fgSelect('Kategori','kategori_keuangan', to_dropdown($kategori_keuangan), null, ['class' => 'form-control'], null, true) }} --}}
                    {{ Form::fgSelect('Nama Perusahaan','id_comprof', to_dropdown($company_name), null, ['class' => 'form-control'], null, true) }}
                    {{-- <label>Pilih file[.txt]</label>
                    <div class="form-group">
                        <input type="file" name="file" required="required">
                    </div> --}}

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
        {{ Form::close() }}
    </div>
</div>

@if(count($data))
<div class="card card-success">
    <div class="card-body">
        <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
            <thead>
                <tr>
                    <th>{{ __('label.action') }}</th>
                    {{-- <th>No.</th> --}}
                    <th>Lembaga Jasa Keuangan</th>
                    <th>Periode Bulan</th>
                    <th>Tahun</th>
                    {{-- <th>Keterangan</th> --}}
                </tr>
            </thead>
            <tbody>
                @php $i=1 @endphp
                @foreach ($data as $d) 
                <tr>
                    <td>
                        {!! Html::linkShowDelete('realisasi-rbb', ['id' => $d->id, 'label' => $company_name[$d->id_comprof].' '.$bulan[$d->bulan].' '.$d->tahun]) !!}
                    </td>
                    {{-- <td>{{$i++}}</td> --}}
                    <td>{{ $d->id_comprof !== '-' ? $company_name[$d->id_comprof] : $d->id_comprof }}</td>
                    <td>{{$bulan[$d->bulan]}}</td>
                    <td>{{$d->tahun}}</td>
                    {{-- <td><span class="badge bg-{{ $d->status_progres == 0 ? 'warning' : 'success'}}">{{$d->status_progres == 0 ? 'Draft' : 'Aprove'}} --}}
                    {{-- <td><span class="badge bg-{{ $d->kategori_keuangan == 1 ? 'info' : 'primary'}}">{{ $d->kategori_keuangan !== '-' ? $kategori_keuangan[$d->kategori_keuangan] : $d->kategori_keuangan }}</td> --}}
                    
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="row">
            <div class="col-6">
                {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('realisasi-rbb'))->links() }}
            </div>

            <div class="col-6 text-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importExcel">
                    Tambah Data
                </button>
            </div>
        </div>
    </div>
</div>
@else
<div class="alert alert-warning">
    Data tidak ditemukan untuk `<strong>Realisasi RBB</strong>`. Klik untuk membuat data baru &nbsp;
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importExcel">
        Tambah Data
    </button>
</div>
@endif
@endsection