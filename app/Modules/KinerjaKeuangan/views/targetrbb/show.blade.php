@php
$segment = request()->segment(2);
$title = 'show'; $method = 'put'; $action = ['target-rbb.update', $targetrbb->id];
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' Target - RBB')
@section('content')
{{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off', 'files' => false]) }}
<div class="card">
    <div class="card-header text-right">
        <a type="button" href="{{url('target-rbb')}}" class="btn btn-sm btn-flat btn-warning"><i class="fa fa-arrow-circle-left"></i>&nbsp;&nbsp;Kembali</a>&nbsp;
        {{-- @if($targetrbb->status_progres === 2)
        <a type="button" href="{{url('target-rbb/aktivasi', $targetrbb->id)}}" class="btn btn-sm btn-flat btn-success" title="Aktifkan TargetRBB" rel="action"><i class="fa fa-arrow-alt-circle-up"></i>&nbsp;&nbsp;Aktifkan</a>
        @endif --}}
    </div>
    <div class="card-body">
        <div class="col-sm-12" style="font-size: 15px;line-height: 32px;font-family: Arial, Helvetica, sans-serif;">
            <div class="col-sm-7">
                <table>
                    <tr>
                        <td style="width:250px">Lembaga Jasa Keuangan</td>
                        <td style="width:25px">:</td>
                        <td>{{$company_name[$targetrbb->id_comprof]}}</td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-7">
                <table>
                    <tr>
                        <td style="width:250px">Status Dokumen</td>
                        <td style="width:25px">:</td>
                        <td>{{$targetrbb->status_progres == 2 ? 'Tidak Aktif' : 'Aktif'}}</td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-7">
                <table>
                    <tr>
                        <td style="width:250px">Tahun</td>
                        <td style="width:25px">:</td>
                        <td>{{$targetrbb->tahun}}</td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-7">
                <table>
                    <tr>
                        <td style="width:250px">Kategori Keuangan</td>
                        <td style="width:25px">:</td>
                        <td>{{$kategori_keuangan[$targetrbb->kategori_keuangan]}}</td>
                    </tr>
                </table>
            </div>
        </div><br><hr>
        {{-- @if($targetrbb->kategori_keuangan == 1)
        <div class="row">
            @foreach($targetrbb_detail as $b)
            <div class="col-md-4 m-b-10">
                <h5><b>{{ $b->periode !== '-' ? $bulan[$b->periode] : $b->periode }}</b></h5>
                <div class="row">
                    <div class="col-md-5">Total Aset</div>
                    <div>:</div>
                    <div class="col-md-4" style="text-align: right;">{{ number_format($b->total_aset*1000000) }}</div>
                    <div class="col-md-5">Total ABA</div>
                    <div>:</div>
                    <div class="col-md-4" style="text-align: right;">{{ number_format($b->total_aba*1000000) }}</div>
                    <div class="col-md-5">Total Kredit</div>
                    <div>:</div>
                    <div class="col-md-4" style="text-align: right;">{{ number_format($b->total_kredit*1000000) }}</div>
                    <div class="col-md-5">Dana Pihak Ketiga</div>
                    <div>:</div>
                    <div class="col-md-4" style="text-align: right;">{{ number_format($b->dana_pihak_ketiga*1000000) }}</div>
                    <div class="col-md-5">Simpanan Bank Lain</div>
                    <div>:</div>
                    <div class="col-md-4" style="text-align: right;">{{ number_format($b->simpanan_bank_lain*1000000) }}</div>
                    <div class="col-md-5">Pinjaman Yang Diterima</div>
                    <div>:</div>
                    <div class="col-md-4" style="text-align: right;">{{ number_format($b->pinjaman_yang_diterima*1000000) }}</div>
                    <div class="col-md-5">Modal</div>
                    <div>:</div>
                    <div class="col-md-4" style="text-align: right;">{{ number_format($b->modal*1000000) }}</div>
                    <div class="col-md-5">Laba/Rugi</div>
                    <div>:</div>
                    <div class="col-md-4" style="text-align: right;">{{ number_format($b->laba_rugi*1000000) }}</div>
                </div>
                <hr>
            </div>
            @endforeach
        </div>
        @else
        <div class="row">
            @foreach($targetrbb_detail as $b)
            <div class="col-md-4 m-b-10">
                <h5><b>{{ $b->periode !== '-' ? $bulan[$b->periode] : $b->periode }}</b></h5>
                <div class="row">
                    <div class="col-md-5">Bunga Kredit</div>
                    <div>:</div>
                    <div class="col-md-4" style="text-align: right;">{{ number_format($b->bunga_kredit*1000000) }}</div>
                    <div class="col-md-5">Bunga PPBL</div>
                    <div>:</div>
                    <div class="col-md-4" style="text-align: right;">{{ number_format($b->bunga_ppbl*1000000) }}</div>
                    <div class="col-md-5">Pendapatan Provisi</div>
                    <div>:</div>
                    <div class="col-md-4" style="text-align: right;">{{ number_format($b->pendapatan_provinsi*1000000) }}</div>
                    <div class="col-md-5">Pendapatan Lainnya</div>
                    <div>:</div>
                    <div class="col-md-4" style="text-align: right;">{{ number_format($b->pendapatan_lainnya*1000000) }}</div>
                    <div class="col-md-5">Tabungan</div>
                    <div>:</div>
                    <div class="col-md-4" style="text-align: right;">{{ number_format($b->tabungan*1000000) }}</div>
                    <div class="col-md-5">Deposito</div>
                    <div>:</div>
                    <div class="col-md-4" style="text-align: right;">{{ number_format($b->deposito*1000000) }}</div>
                    <div class="col-md-5">Pinjaman Diterima</div>
                    <div>:</div>
                    <div class="col-md-4" style="text-align: right;">{{ number_format($b->pinjaman_diterima*1000000) }}</div>
                    <div class="col-md-5">Simpanan Bank Lain</div>
                    <div>:</div>
                    <div class="col-md-4" style="text-align: right;">{{ number_format($b->simpanan_banklain*1000000) }}</div>
                    <div class="col-md-5">Penyusutan ATI</div>
                    <div>:</div>
                    <div class="col-md-4" style="text-align: right;">{{ number_format($b->penyusutan_ati*1000000) }}</div>
                    <div class="col-md-5">Penyisihan Kerugian</div>
                    <div>:</div>
                    <div class="col-md-4" style="text-align: right;">{{ number_format($b->beban_restrukturisasi*1000000) }}</div>
                    <div class="col-md-5">Penyisihan Kerugian</div>
                    <div>:</div>
                    <div class="col-md-4" style="text-align: right;">{{ number_format($b->beban_pemasaran*1000000) }}</div>
                    <div class="col-md-5">Penyisihan Kerugian</div>
                    <div>:</div>
                    <div class="col-md-4" style="text-align: right;">{{ number_format($b->tenaga_kerja*1000000) }}</div>
                    <div class="col-md-5">Penyisihan Kerugian</div>
                    <div>:</div>
                    <div class="col-md-4" style="text-align: right;">{{ number_format($b->pendidikan*1000000) }}</div>
                    <div class="col-md-5">Premi Asuransi</div>
                    <div>:</div>
                    <div class="col-md-4" style="text-align: right;">{{ number_format($b->premi_asuransi*1000000) }}</div>
                    <div class="col-md-5">Sewa</div>
                    <div>:</div>
                    <div class="col-md-4" style="text-align: right;">{{ number_format($b->sewa*1000000) }}</div>
                    <div class="col-md-5">Barang dan Jasa</div>
                    <div>:</div>
                    <div class="col-md-4" style="text-align: right;">{{ number_format($b->barang_dan_jasa*1000000) }}</div>
                    <div class="col-md-5">Pemeliharaan & Perbaikan</div>
                    <div>:</div>
                    <div class="col-md-4" style="text-align: right;">{{ number_format($b->pemeliharaan_perbaikan*1000000) }}</div>
                    <div class="col-md-5">Pajak - Pajak</div>
                    <div>:</div>
                    <div class="col-md-4" style="text-align: right;">{{ number_format($b->pajak*1000000) }}</div>
                    <div class="col-md-5">Beban Lainnya</div>
                    <div>:</div>
                    <div class="col-md-4" style="text-align: right;">{{ number_format($b->beban_lainnya*1000000) }}</div>
                    <div class="col-md-5">Laba/Rugi</div>
                    <div>:</div>
                    <div class="col-md-4" style="text-align: right;">{{ number_format($b->laba_rugi*1000000) }}</div>
                </div>
            </div>
            @endforeach
        </div>
        @endif --}}

        @if($targetrbb->kategori_keuangan == 1)
    <div class="col-xs-12">
        <table border="3">
            <tr style="text-align: center">
                <th rowspan="1" colspan="9" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Target RBB Perkembangan Volume Usaha</th>
            </tr>
            <tr style=" text-align: center">
                <th rowspan="2" colspan="1" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Periode</th>
                <th rowspan="2" colspan="1" style="width:300px; color: white; background-color:rgb(0, 0, 0)"">Total Aset</th>
                <th colspan="2" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Penyaluran Dana</th>
                <th colspan="5" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Sumber Dana</th>
            </tr>
            <tr style=" text-align: center">
                <th colspan="1" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Total ABA</th>
                <th colspan="1" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Total Kredit</th>
                <th colspan="1" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Dana Pihak Ketiga</th>
                <th colspan="1" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Simpanan Bank Lain</th>
                <th colspan="1" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Pinjaman Yang Diterima</th>
                <th colspan="1" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Modal</th>
                <th colspan="1" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Laba Rugi</th>
            </tr>
            @foreach($targetrbb_detail as $b)
            <tr style=" text-align: center">
                <td>{{$b->periode}}</td>
                <td>{{ number_format($b->total_aset*1000000) }}</td>
                <td>{{ number_format($b->total_aba*1000000) }}</td>
                <td>{{ number_format($b->total_kredit*1000000) }}</td>
                <td>{{ number_format($b->dana_pihak_ketiga*1000000) }}</td>
                <td>{{ number_format($b->simpanan_bank_lain*1000000) }}</td>
                <td>{{ number_format($b->pinjaman_yang_diterima*1000000) }}</td>
                <td>{{ number_format($b->modal*1000000) }}</td>
                <td>{{ number_format($b->laba_rugi*1000000) }}</td>
            </tr>
            @endforeach
        </table>
    </div>
    @else
    <div class="col-xs-12">
        <table border="3" style="font-size: 8px">
            <tr style="text-align: center; font-size: 8px">
                <th rowspan="1" colspan="21" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Target RBB Laba Rugi</th>
            </tr>
            <tr style=" text-align: center">
                <th rowspan="3" colspan="1" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Periode</th>
                <th colspan="4" style="width:300px; color: white; background-color:rgb(0, 0, 0)"">Pendapatan Operasional</th>
                <th colspan="15" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Beban Operasional</th>
                <th rowspan="3" colspan="1" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Laba Rugi</th>
            </tr>
            <tr style=" text-align: center">
                <th colspan="2" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Pendapatan Bunga</th>
                <th rowspan="2" colspan="1" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Pendapatan Provisi</th>
                <th rowspan="2" colspan="1" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Pendapatan Lainya</th>
                <th colspan="3" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Beban Bunga</th>
                <th rowspan="2" colspan="1" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Penyisihan Kerugian</th>
                <th rowspan="2" colspan="1" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Penyusutan ATI</th>
                <th rowspan="2" colspan="1" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Beban Restrukturisasi</th>
                <th rowspan="2" colspan="1" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Beban Pemasaran</th>
                <th rowspan="2" colspan="1" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Tenaga Kerja</th>
                <th rowspan="2" colspan="1" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Pendidikan</th>
                <th rowspan="2" colspan="1" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Permi Asuransi</th>
                <th rowspan="2" colspan="1" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Sewa</th>
                <th rowspan="2" colspan="1" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Barang dan Jasa</th>
                <th rowspan="2" colspan="1" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Pemeliharaan dan Perbaikan</th>
                <th rowspan="2" colspan="1" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Pajak Pajak</th>
                <th rowspan="2" colspan="1" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Beban Lainya</th>
            </tr>
            <tr style=" text-align: center">
                <th colspan="1" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Bunga Kredit</th>
                <th colspan="1" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Bunga PPBL</th>
                <th colspan="1" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Tabungan</th>
                <th colspan="1" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Deposito</th>
                <th colspan="1" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Pinjaman Diterima</th>
            </tr>
            @foreach($targetrbb_detail as $b)
            <tr style=" text-align: center">
                <td>{{$b->periode}}</td>
                <td>{{ number_format($b->bunga_kredit*1000000) }}</td>
                <td>{{ number_format($b->bunga_ppbl*1000000) }}</td>
                <td>{{ number_format($b->pendapatan_provinsi*1000000) }}</td>
                <td>{{ number_format($b->pendapatan_lainnya*1000000) }}</td>
                <td>{{ number_format($b->tabungan*1000000) }}</td>
                <td>{{ number_format($b->deposito*1000000) }}</td>
                <td>{{ number_format($b->pinjaman_diterima*1000000) }}</td>
                <td>{{ number_format($b->simpanan_banklain*1000000) }}</td>
                <td>{{ number_format($b->penyusutan_ati*1000000) }}</td>
                <td>{{ number_format($b->beban_restrukturisasi*1000000) }}</td>
                <td>{{ number_format($b->beban_pemasaran*1000000) }}</td>
                <td>{{ number_format($b->tenaga_kerja*1000000) }}</td>
                <td>{{ number_format($b->pendidikan*1000000) }}</td>
                <td>{{ number_format($b->premi_asuransi*1000000) }}</td>
                <td>{{ number_format($b->sewa*1000000) }}</td>
                <td>{{ number_format($b->barang_dan_jasa*1000000) }}</td>
                <td>{{ number_format($b->pemeliharaan_perbaikan*1000000) }}</td>
                <td>{{ number_format($b->pajak*1000000) }}</td>
                <td>{{ number_format($b->beban_lainnya*1000000) }}</td>
                <td>{{ number_format($b->laba_rugi*1000000) }}</td>
            </tr>
            @endforeach
        </table>
    </div>
    @endif

    </div>
</div>
{{ Form::close() }}
@endsection