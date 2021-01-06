@extends('layouts.app')
@section('title', 'Laba Rugi')
@section('content')
<div class="card">
    <div class="card-header">
        <a type="button" href="{{url('realisasi-rbb', $datas->id_realisasirbb)}}" class="btn btn-sm btn-flat btn-default"><i class="fa fa-arrow-circle-left"></i>&nbsp;&nbsp;Back</a>&nbsp;
        <a type="button" href="{{url('realisasi-rbb/export', $datas->id_realisasi_detail)}}" type="button" class="btn btn-sm btn-flat btn-success"><i class="fa fa-file-excel"></i>&nbsp;&nbsp;Export Excel</a>
    </div>
    <div class="card-body">
        <div class="col-xs-12"> 
            <table border="3">
                <tr style="text-align: center">
                    <th rowspan="2" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Indikator</th>
                    <th rowspan="2" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">{{$bulan[$datas->bulan]}} - {{$datas->tahun-1}}</th>
                    <th rowspan="2" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">{{$bulan[$datas->bulan]}} - {{$datas->tahun}}</th>
                    <th rowspan="2" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Target <br>{{$bulan[$datas->bulan]}} {{$datas->tahun}}</th>
                    <th colspan="2" style="width:300px; color: white; background-color:rgb(0, 0, 0)"">Pertumbuhan YoY</th>
                    <th rowspan="2" style="width:180px; color: white; background-color:rgb(0, 0, 0)"">Pencapaian RBB</th>
                </tr>
                <tr style="text-align: center">
                    <th style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Rp</th>
                    <th style="width:200px; color: white; background-color:rgb(0, 0, 0)"">%</th>
                </tr>
                <tr style="font-weight: bold; text-align: center">
                    <td style="text-align: left">Pendapatan Operasional</td>
                    <td align="right">@currency($pendops_realisasi_last)</td>
                    <td align="right">@currency($pendops_realisasi)</td>
                    <td align="right">@currency($pendops_realisasi_target)</td>
                    @if($p_pendops < 0)
                    <td align="right">(@currency($p_pendops))</td>
                    @else
                    <td align="right">@currency($p_pendops)</td>
                    @endif
                    <td>{{$p_persen_pendops}}%</td>
                    <td>{{$p_pendops_penc}}%</td>
                </tr>
                <tr>
                    <td>Bunga:</td>
                    <td colspan="6"></td>
                </tr>
                <tr style="text-align: center">
                    <td style="text-align: left">&nbsp;&nbsp;- Bunga Kredit</td>
                    <td align="right">@if(is_null($last)) - @else @currency($last->bunga_kredit) @endif</td>
                    <td align="right">@currency($datas->bunga_kredit)</td>
                    <td align="right">@if(is_null($target)) - @else @currency($target->bunga_kredit * 1000000) @endif</td>
                    @if($p_bungakredit < 0)
                    <td align="right">(@currency($p_bungakredit))</td>
                    @else
                    <td align="right">@currency($p_bungakredit)</td>
                    @endif
                    <td>{{$p_persen_bungakredit}}%</td>
                    <td>{{$p_bungakredit_penc}}%</td>
                </tr>
                <tr style="text-align: center">
                    <td style="text-align: left">&nbsp;&nbsp;- Bunga PPBL</td>
                    <td align="right">@if(is_null($last)) - @else @currency($last->bunga_ppbl) @endif</td>
                    <td align="right">@currency($datas->bunga_ppbl)</td>
                    <td align="right">@if(is_null($target)) - @else @currency($target->bunga_ppbl * 1000000) @endif</td>
                    @if($p_bungappbl < 0)
                    <td align="right">(@currency($p_bungappbl))</td>
                    @else
                    <td align="right">@currency($p_bungappbl)</td>
                    @endif
                    <td>{{$p_persen_bungappbl}}%</td>
                    <td>{{$p_bungappbl_penc}}%</td>
                </tr>
                <tr style=" text-align: center">
                    <td style="text-align: left">Pendapatan Provisi</td>
                    <td align="right">@if(is_null($last)) - @else @currency($last->pend_provisi) @endif</td>
                    <td align="right">@currency($datas->pend_provisi)</td>
                    <td align="right">@if(is_null($target)) - @else @currency($target->pendapatan_provinsi * 1000000) @endif</td>
                    @if($p_pendprov < 0)
                    <td align="right">(@currency($p_pendprov))</td>
                    @else
                    <td align="right">@currency($p_pendprov)</td>
                    @endif
                    <td>{{$p_persen_pendprov}}%</td>
                    <td>{{$p_pendprov_penc}}%</td>
                </tr>
                <tr style=" text-align: center">
                    <td style="text-align: left">Pendapatan Lainya</td>
                    <td align="right">@if(is_null($last)) - @else @currency($last->pend_lainya) @endif</td>
                    <td align="right">@currency($datas->pend_lainya)</td>
                    <td align="right">@if(is_null($target)) - @else @currency($target->pendapatan_lainnya * 1000000) @endif</td>
                    @if($p_pendlainya < 0)
                    <td align="right">(@currency($p_pendlainya))</td>
                    @else
                    <td align="right">@currency($p_pendlainya)</td>
                    @endif
                    <td>{{$p_persen_pendlainya}}%</td>
                    <td>{{$p_pendlainya_penc}}%</td>
                </tr>
                <tr style="font-weight: bold; text-align: center">
                    <td style="text-align: left">Beban Operasional</td>
                    <td align="right">@currency($bebanops_realisasi_last)</td>
                    <td align="right">@currency($bebanops_realisasi)</td>
                    <td align="right">@currency($bebanops_realisasi_target)</td>
                    @if($p_bebanops < 0)
                    <td align="right">(@currency($p_bebanops))</td>
                    @else
                    <td align="right">@currency($p_bebanops)</td>
                    @endif
                    <td>{{$p_persen_bebanops}}%</td>
                    <td>{{$p_bebanops_penc}}%</td>
                </tr>
                <tr style="font-weight: bold; text-align: center">
                    <td style="text-align: left">Bunga</td>
                    <td align="right">@currency($bunga_realisasi_last)</td>
                    <td align="right">@currency($bunga_realisasi)</td>
                    <td align="right">@currency($bunga_realisasi_target)</td>
                    @if($p_bunga < 0)
                    <td align="right">(@currency($p_bunga))</td>
                    @else
                    <td align="right">@currency($p_bunga)</td>
                    @endif
                    <td>{{$p_persen_bunga}}%</td>
                    <td>{{$p_bunga_penc}}%</td>
                </tr>
                <tr style="text-align: center">
                    <td style="text-align: left">&nbsp;&nbsp;- Tabungan</td>
                    <td align="right">@if(is_null($last)) - @else @currency($last->tabungan) @endif</td>
                    <td align="right">@currency($datas->tabungan)</td>
                    <td align="right">@if(is_null($target)) - @else @currency($target->tabungan * 1000000) @endif</td>
                    @if($p_tabungan < 0)
                    <td align="right">(@currency($p_tabungan))</td>
                    @else
                    <td align="right">@currency($p_tabungan)</td>
                    @endif
                    <td>{{$p_persen_tabungan}}%</td>
                    <td>{{$p_tabungan_penc}}%</td>
                </tr>
                <tr style="text-align: center">
                    <td style="text-align: left">&nbsp;&nbsp;- Deposito</td>
                    <td align="right">@if(is_null($last)) - @else @currency($last->deposito) @endif</td>
                    <td align="right">@currency($datas->deposito)</td>
                    <td align="right">@if(is_null($target)) - @else @currency($target->deposito * 1000000) @endif</td>
                    @if($p_deposito < 0)
                    <td align="right">(@currency($p_deposito))</td>
                    @else
                    <td align="right">@currency($p_deposito)</td>
                    @endif
                    <td>{{$p_persen_deposito}}%</td>
                    <td>{{$p_deposito_penc}}%</td>
                </tr>
                <tr style="text-align: center">
                    <td style="text-align: left">&nbsp;&nbsp;- Simpanan Bank Lain</td>
                    <td align="right">@if(is_null($last)) - @else @currency($last->sbl) @endif</td>
                    <td align="right">@currency($datas->sbl)</td>
                    <td align="right">@if(is_null($target)) - @else @currency($target->simpanan_banklain * 1000000) @endif</td>
                    @if($p_sbl < 0)
                    <td align="right">(@currency($p_sbl))</td>
                    @else
                    <td align="right">@currency($p_sbl)</td>
                    @endif
                    <td>{{$p_persen_sbl}}%</td>
                    <td>{{$p_sbl_penc}}%</td>
                </tr>
                <tr style="text-align: center">
                    <td style="text-align: left">&nbsp;&nbsp;- Pinjaman Diterima</td>
                    <td align="right">@if(is_null($last)) - @else @currency($last->pin_diterima) @endif</td>
                    <td align="right">@currency($datas->pin_diterima)</td>
                    <td align="right">@if(is_null($target)) - @else @currency($target->pinjaman_diterima * 1000000) @endif</td>
                    @if($p_pin_diterima < 0)
                    <td align="right">(@currency($p_pin_diterima))</td>
                    @else
                    <td align="right">@currency($p_pin_diterima)</td>
                    @endif
                    <td>{{$p_persen_pin_diterima}}%</td>
                    <td>{{$p_pin_diterima_penc}}%</td>
                </tr>
                <tr style="text-align: center">
                    <td style="text-align: left">Penyisihan Kerugian</td>
                    <td align="right">@if(is_null($last)) - @else @currency($last->peny_kerugian) @endif</td>
                    <td align="right">@currency($datas->peny_kerugian)</td>
                    <td align="right">@if(is_null($target)) - @else @currency($target->penyisihan_kerugian * 1000000) @endif</td>
                    @if($p_peny_kerugian < 0)
                    <td align="right">(@currency($p_peny_kerugian))</td>
                    @else
                    <td align="right">@currency($p_peny_kerugian)</td>
                    @endif
                    <td>{{$p_persen_peny_kerugian}}%</td>
                    <td>{{$p_peny_kerugian_penc}}%</td>
                </tr>
                <tr style="text-align: center">
                    <td style="text-align: left">Penyusutan Aset</td>
                    <td align="right">@if(is_null($last)) - @else @currency($last->peny_ATI) @endif</td>
                    <td align="right">@currency($datas->peny_ATI)</td>
                    <td align="right">@if(is_null($target)) - @else @currency($target->penyusutan_ati * 1000000) @endif</td>
                    @if($p_peny_ATI < 0)
                    <td align="right">(@currency($p_peny_ATI))</td>
                    @else
                    <td align="right">@currency($p_peny_ATI)</td>
                    @endif
                    <td>{{$p_persen_peny_ATI}}%</td>
                    <td>{{$p_peny_ATI_penc}}%</td>
                </tr>
                <tr style="text-align: center">
                    <td style="text-align: left">Tenaga Kerja</td>
                    <td align="right">@if(is_null($last)) - @else @currency($last->tenaga_kerja) @endif</td>
                    <td align="right">@currency($datas->tenaga_kerja)</td>
                    <td align="right">@if(is_null($target)) - @else @currency($target->tenaga_kerja * 1000000) @endif</td>
                    @if($p_tenaga_kerja < 0)
                    <td align="right">(@currency($p_tenaga_kerja))</td>
                    @else
                    <td align="right">@currency($p_tenaga_kerja)</td>
                    @endif
                    <td>{{$p_persen_tenaga_kerja}}%</td>
                    <td>{{$p_tenaga_kerja_penc}}%</td>
                </tr>
                <tr style="text-align: center">
                    <td style="text-align: left">Pendidikan</td>
                    <td align="right">@if(is_null($last)) - @else @currency($last->pendidikan) @endif</td>
                    <td align="right">@currency($datas->pendidikan)</td>
                    <td align="right">@if(is_null($target)) - @else @currency($target->pendidikan * 1000000) @endif</td>
                    @if($p_pendidikan < 0)
                    <td align="right">(@currency($p_pendidikan))</td>
                    @else
                    <td align="right">@currency($p_pendidikan)</td>
                    @endif
                    <td>{{$p_persen_pendidikan}}%</td>
                    <td>{{$p_pendidikan_penc}}%</td>
                </tr>
                <tr style="text-align: center">
                    <td style="text-align: left">Premi Asuransi</td>
                    <td align="right">@if(is_null($last)) - @else @currency($last->premi_asuransi) @endif</td>
                    <td align="right">@currency($datas->premi_asuransi)</td>
                    <td align="right">@if(is_null($target)) - @else @currency($target->premi_asuransi * 1000000) @endif</td>
                    @if($p_premi_asuransi < 0)
                    <td align="right">(@currency($p_premi_asuransi))</td>
                    @else
                    <td align="right">@currency($p_premi_asuransi)</td>
                    @endif
                    <td>{{$p_persen_premi_asuransi}}%</td>
                    <td>{{$p_premi_asuransi_penc}}%</td>
                </tr>
                <tr style="text-align: center">
                    <td style="text-align: left">Sewa</td>
                    <td align="right">@if(is_null($last)) - @else @currency($last->sewa) @endif</td>
                    <td align="right">@currency($datas->sewa)</td>
                    <td align="right">@if(is_null($target)) - @else @currency($target->sewa * 1000000) @endif</td>
                    @if($p_sewa < 0)
                    <td align="right">(@currency($p_sewa))</td>
                    @else
                    <td align="right">@currency($p_sewa)</td>
                    @endif
                    <td>{{$p_persen_sewa}}%</td>
                    <td>{{$p_sewa_penc}}%</td>
                </tr>
                <tr style="text-align: center">
                    <td style="text-align: left">Pemeliharaan & Perbaikan</td>
                    <td align="right">@if(is_null($last)) - @else @currency($last->pemeliharaan_perbaikan) @endif</td>
                    <td align="right">@currency($datas->pemeliharaan_perbaikan)</td>
                    <td align="right">@if(is_null($target)) - @else @currency($target->pemeliharaan_perbaikan * 1000000) @endif</td>
                    @if($p_pemeliharaan_perbaikan < 0)
                    <td align="right">(@currency($p_pemeliharaan_perbaikan))</td>
                    @else
                    <td align="right">@currency($p_pemeliharaan_perbaikan)</td>
                    @endif
                    <td>{{$p_persen_pemeliharaan_perbaikan}}%</td>
                    <td>{{$p_pemeliharaan_perbaikan_penc}}%</td>
                </tr>
                <tr style="text-align: center">
                    <td style="text-align: left">Barang dan Jasa</td>
                    <td align="right">@if(is_null($last)) - @else @currency($last->barangjasa) @endif</td>
                    <td align="right">@currency($datas->barangjasa)</td>
                    <td align="right">@if(is_null($target)) - @else @currency($target->barang_dan_jasa * 1000000) @endif</td>
                    @if($p_barangjasa < 0)
                    <td align="right">(@currency($p_barangjasa))</td>
                    @else
                    <td align="right">@currency($p_barangjasa)</td>
                    @endif
                    <td>{{$p_persen_barangjasa}}%</td>
                    <td>{{$p_barangjasa_penc}}%</td>
                </tr>
                <tr style="text-align: center">
                    <td style="text-align: left">Beban Lainya</td>
                    <td align="right">@if(is_null($last)) - @else @currency($last->bebanlainya) @endif</td>
                    <td align="right">@currency($datas->bebanlainya)</td>
                    <td align="right">@if(is_null($target)) - @else @currency($target->beban_lainnya * 1000000) @endif</td>
                    @if($p_bebanlainya < 0)
                    <td align="right">(@currency($p_bebanlainya))</td>
                    @else
                    <td align="right">@currency($p_bebanlainya)</td>
                    @endif
                    <td>{{$p_persen_bebanlainya}}%</td>
                    <td>{{$p_bebanlainya_penc}}%</td>
                </tr>
                <tr style="font-weight: bold; text-align: center">
                    <td style="text-align: left">Laba / Rugi</td>
                    <td align="right">@if(is_null($last)) - @else @currency($last->labarugi) @endif</td>
                    <td align="right">@currency($datas->labarugi)</td>
                    <td align="right">@if(is_null($target)) - @else @currency($target->laba_rugi * 1000000) @endif</td>
                    @if($p_labarugi < 0)
                    <td align="right">(@currency($p_labarugi))</td>
                    @else
                    <td align="right">@currency($p_labarugi)</td>
                    @endif
                    <td>{{$p_persen_labarugi}}%</td>
                    <td>{{$p_labarugi_penc}}%</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection