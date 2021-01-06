@php
$segment = request()->segment(2);
$title = 'create'; $method = 'post'; $action = 'realisasi-rbb.store';
if ($segment !== 'create' ) { $title = 'show'; $method = 'post'; $action = ['realisasi-rbb.upload', $realisasi_rbb->id]; }
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' Realisasi')
@section('content')
<div class="card">
    <div class="card-header text-right">
        {{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-data', 'autocomplete' => 'off', 'files' => true]) }}
        <a type="button" href="{{url('realisasi-rbb')}}" class="btn btn-sm btn-flat btn-default"><i class="fa fa-arrow-circle-left"></i>&nbsp;&nbsp;Kembali</a>&nbsp;
        <button type="button" class="btn btn-sm btn-flat btn-info" data-toggle="modal" data-target="#info"><i class="fa fa-info-circle"></i>&nbsp;&nbsp;Panduan</button>&nbsp;
        @if($realisasi_rbb->status_progres == 0)
        <button type="button" class="btn btn-sm btn-flat btn-secondary" data-toggle="modal" data-target="#importTXT"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Upload File</button>&nbsp;
        {{-- <a type="button" href="#" class="btn btn-sm btn-flat btn-success" title="Ajukan Dokumen" rel="action"><i class="fa fa-arrow-alt-circle-up"></i>&nbsp;&nbsp;Ajukan</a> --}}
        @else
        @endif
        {{ Form::close() }}
    </div>
    <div class="card-body">
        <div class="col-sm-12" style="font-size: 15px;line-height: 32px;font-family: Arial, Helvetica, sans-serif;">
            <div class="col-sm-7">
                <table>
                    <tr>
                        <td style="width:250px">Lembaga Jasa Keuangan</td>
                        <td style="width:25px">:</td>
                        <td>{{$company_name[$realisasi_rbb->id_comprof]}}</td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-7">
                <table>
                    <tr>
                        <td style="width:250px">Status Dokumen</td>
                        <td style="width:25px">:</td>
                        <td>{{$realisasi_rbb->status_progres == 0 ? 'Draft' : 'Approve'}}</td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-7">
                <table>
                    <tr>
                        <td style="width:250px">Periode Bulan</td>
                        <td style="width:25px">:</td>
                        <td>{{$bulan[$realisasi_rbb->bulan]}}</td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-7">
                <table>
                    <tr>
                        <td style="width:250px">Tahun</td>
                        <td style="width:25px">:</td>
                        <td>{{$realisasi_rbb->tahun}}</td>
                    </tr>
                </table>
            </div>
        </div><br>
        <div class="col-md-12">
            <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Kategori Keuangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @php $i=1 @endphp --}}
                    @foreach($data as $d)
                    <tr>
                        <td style="width:100px">{{$d->kategori_keuangan}}</td>
                        <td style="width:1000px">{{$kategori_keuangan[$d->kategori_keuangan]}}</td>
                        <td>
                            <a type="button" href="{{url('realisasi-rbb/kategori', $d->id)}}" class="btn btn-sm btn-flat btn-warning"><i class="fa fa-book"></i>&nbsp;&nbsp;Detail</a>&nbsp;
                            @if($realisasi_rbb->status_progres === 0)
                            <a type="button" href="{{url('realisasi-rbb/hapusKategori', $d->id)}}" class="btn btn-sm btn-flat btn-danger" title="Hapus Dokumen {{$kategori_keuangan[$d->kategori_keuangan]}}" rel="action"><i class="fa fa-trash-alt"></i>&nbsp;&nbsp;Delete</a>
                            @else
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="importTXT" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        {{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off', 'files' => true]) }}
        <form method="post" action="" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Data [.txt]</h5>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    <?php ksort($kategori_keuangan); ?>
                    {{ Form::fgSelect('Kategori','kategori_keuangan', to_dropdown($kategori_keuangan), null, ['class' => 'form-control', 'id' => 'kategori'], null, true) }}
                    <div style="display:none;" id="car">
                        {{ Form::fgText('Kredit Diberikan', 'kredit_diberikan', null, ['class' => 'form-control number'], null, 'text', true) }}
                        {{ Form::fgText('Rupa Aktiva', 'rupa_aktiva', null, ['class' => 'form-control number'], null, 'text', true) }}
                        {{ Form::fgText('Modal Pelengkap', 'modal_pelengkap', null, ['class' => 'form-control number'], null, 'text', true) }}
                        {{ Form::fgText('God Will', 'godwill', null, ['class' => 'form-control number'], null, 'text', true) }}
                    </div>
                    <div style="display:none;" id="health">
                        {{ Form::fgText('Bobot CAR', 'bobot_car', null, ['class' => 'form-control numeric', 'step' => 'any', 'placeholder' => '0.00'], null, 'number', true) }}
                        {{ Form::fgText('Bobot KAP', 'bobot_kap', null, ['class' => 'form-control numeric', 'step' => 'any', 'placeholder' => '0.00'], null, 'number', true) }}
                        {{ Form::fgText('Bobot PPAP', 'bobot_ppap', null, ['class' => 'form-control numeric', 'step' => 'any', 'placeholder' => '0.00'], null, 'number', true) }}
                        {{ Form::fgText('Bobot CR', 'bobot_cr', null, ['class' => 'form-control numeric', 'step' => 'any', 'placeholder' => '0.00'], null, 'number', true) }}
                        {{ Form::fgText('Bobot LDR', 'bobot_ldr', null, ['class' => 'form-control numeric', 'step' => 'any', 'placeholder' => '0.00'], null, 'number', true) }}
                        {{ Form::fgText('Bobot ROA', 'bobot_roa', null, ['class' => 'form-control numeric', 'step' => 'any', 'placeholder' => '0.00'], null, 'number', true) }}
                        {{ Form::fgText('Bobot BOPO', 'bobot_bopo', null, ['class' => 'form-control numeric', 'step' => 'any', 'placeholder' => '0.00'], null, 'number', true) }}
                        {{ Form::fgText('Manajemen Umum', 'manajemen_umum', null, ['class' => 'form-control numeric', 'step' => 'any', 'placeholder' => '0.00'], null, 'number', true) }}
                        {{ Form::fgText('Manajemen Resiko', 'manajemen_resiko', null, ['class' => 'form-control numeric', 'step' => 'any', 'placeholder' => '0.00'], null, 'number', true) }}
                    </div>
                    <div style="display:none;" id="nsfr">
                        {{ Form::fgText('Rasio NSFR', 'nsfr', null, ['class' => 'form-control numeric', 'step' => 'any', 'placeholder' => '0.00%'], null, 'number', true) }}
                        {{-- {{ Form::fgText($bulan[$realisasi_rbb->bulan].' - '.$realisasi_rbb->tahun, 'nsfr', null, ['class' => 'form-control numeric', 'step' => 'any', 'placeholder' => '0.00'], null, 'number', true) }} --}}
                    </div>
                    <div style="display:none;" id="lcr">
                        {{ Form::fgText('Rasio LCR', 'lcr', null, ['class' => 'form-control numeric', 'step' => 'any', 'placeholder' => '0.00%'], null, 'number', true) }}
                    </div>
                    <div id="upload" style="display:none;">
                        <label>Pilih File</label>
                        <div class="form-group">
                            <input type="file" name="file">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="reset" class="btn btn-warning">Reset</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
        {{ Form::close() }}
    </div>
</div>
<div class="modal fade" id="info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="col-12 modal-title text-center" id="exampleModalLabel">PANDUAN URUTAN INPUT DATA & UPLOAD FILE</h5>
            </div>
            <div class="modal-body">
                <div id="upload">
                    <ol>
                        <li>Perkembangan Volume Usaha [File Kode <b>0100</b>]</li>
                        <li>Laba Rugi [File Kode <b>0200</b>]</li>
                        <li>Rasio Keuangan [File Kode <b>0008</b>]</li>
                        <li>Rasio Permodalan</li>
                        <li>Rasio NPL [File Kode <b>0600</b>]</li>
                        <li>Kolek Persektor</li>
                        <li>Cash Ratio [File Kode <b>0500</b>]</li>
                        <li>LDR</li>
                        <li>ROA</li>
                        <li>BOPO</li>
                        <li>Tingkat Kesehatan Bank</li>
                        <li>NSFR</li>
                        <li>LCR</li>
                    </ol>
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-info"></i> Catatan!</h5>
                        Dalam melaksanakan kegiatan input data dan upload file, kami menghimbau agar dilakukan secara berurutan 
                        seperti panduan yang telah kami paparkan diatas.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection