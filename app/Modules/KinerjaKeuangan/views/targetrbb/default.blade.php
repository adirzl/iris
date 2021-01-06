@php
$title = 'create'; $method = 'post'; $action = 'target-rbb.upload';
@endphp
@extends('layouts.app')
@section('title', 'Target RBB')
@section('content')
@include('KinerjaKeuangan::targetrbb.filter')

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
    <div class="modal-dialog" role="document">
        {{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off', 'files' => true]) }}
        <form method="post" action="" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Data</h5>
                </div>
                <div class="modal-body">

                    {{ csrf_field() }}

                    {{ Form::fgText('Tahun', 'tahun', null, ['class' => 'form-control yearpick', 'placeholder' => 'Tahun'], null, 'text', true) }}
                    <?php ksort($kategori_keuangan_ext); ?>
                    {{ Form::fgSelect('Kategori','kategori[]', to_dropdown($kategori_keuangan_ext), null, ['class' => 'form-control'], null, true) }}
                    {{ Form::fgSelect('Nama Perusahaan','company_name[]', to_dropdown($company_name), null, ['class' => 'form-control'], null, true) }}
                    <label>Pilih file excel</label>
                    <div class="form-group">
                        <input type="file" name="file" required="required">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#downloadTemplates">Download Templates</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
        {{ Form::close() }}
    </div>
</div>

<!-- Import Excel --> 
<div class="modal fade" id="downloadTemplates" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Download Templates</h5>
            </div>
            <div class="modal-body">
                <a href="{{asset('TargetRBBPerkembanganUsaha.xlsx')}}" class="btn btn-success"><i class="fas fa-download"></i>&nbsp; RBB Volume Perkembangan Usaha</a>
                <br><br>
                <a href="{{asset('TargetRBBLabaRugi.xlsx')}}" class="btn btn-success"><i class="fas fa-download"></i>&nbsp; Target RBB Laba Rugi</a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@if(count($data))
<div class="card card-success">
    <div class="card-body">
        <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
            <thead>
                <tr>
                    <th>{{ __('label.action') }}</th>
                    <th>No.</th>
                    <th>Lembaga Jasa Keuangan</th>
                    <th>Periode</th>
                    <th>Kategori RBB</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @php $i=1 @endphp
                @foreach ($data as $d)
                <tr>
                    <td>
                        {!! Html::linkShowDelete('target-rbb', ['id' => $d->id, 'label' => $d->tahun]) !!}
                    </td>
                    <td>{{$i++}}</td>
                    <td>{{ $d->id_comprof !== '-' ? $company_name[$d->id_comprof] : $d->id_comprof }}</td>
                    <td>{{$d->tahun}}</td>
                    <td><span class="badge bg-{{ $d->kategori_keuangan == 1 ? 'info' : 'primary'}}">{{ $d->kategori_keuangan !== '-' ? $kategori_keuangan[$d->kategori_keuangan] : $d->kategori_keuangan }}</td>
                    <td><span class="badge bg-{{ $d->status_progres == 1 ? 'success' : 'warning'}}">{{ $d->status_progres !== '-' ? $status_perusahaan[$d->status_progres] : $d->status_progres }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="row">
            <div class="col-6">
                {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('target-rbb'))->links() }}
            </div>

            <div class="col-6 text-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importExcel">
                    Upload Excel
                </button>
            </div>
        </div>
    </div>
</div>
@else
<div class="alert alert-warning">
    Data tidak ditemukan untuk `<strong>Target RBB</strong>`. Klik untuk membuat data baru &nbsp;
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importExcel">
        Upload Excel
    </button>
</div>
@endif
@endsection