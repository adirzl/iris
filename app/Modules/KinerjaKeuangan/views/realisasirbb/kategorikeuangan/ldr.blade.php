@extends('layouts.app')
@section('title', 'LDR')
@section('content')
<div class="card">
    <div class="card-header">
        <a type="button" href="{{url('realisasi-rbb', $datas->id_realisasirbb)}}" class="btn btn-sm btn-flat btn-default"><i class="fa fa-arrow-circle-left"></i>&nbsp;&nbsp;Back</a>&nbsp;
        <a type="button" href="{{url('realisasi-rbb/export', $datas->id_realisasi_detail)}}" class="btn btn-sm btn-flat btn-success"><i class="fa fa-file-excel"></i>&nbsp;&nbsp;Export Excel</a>
    </div>
    <div class="card-body">
        <div class="col-xs-12">
            <table border="3">
                <tr style="text-align: center">
                    <th rowspan="2" style="width:350px; color: white; background-color:rgb(0, 0, 0)"">Keterangan</th>
                    <th rowspan="2" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">{{$bulan[$datas->bulan]}} - {{$datas->tahun - 1}}</th>
                    <th rowspan="2" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">{{$bulan[$datas->bulan]}} - {{$datas->tahun}}</th>
                    <th colspan="2" style="width:300px; color: white; background-color:rgb(0, 0, 0)"">Naik/Turun</th>
                </tr>
                <tr style="text-align: center">
                    <th style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Rp</th>
                    <th style=" width:200px; color: white; background-color:rgb(0, 0, 0)"">%</th>
                </tr>
                <tr style="font-weight: bold; text-align: center; background-color:rgb(214, 230, 250)"">
                    <td style="text-align: left">LDR</td>
                    <td align="right">@if(is_null($lastyear)) - @else {{$lastyear->ldr}}% @endif</td>
                    <td align="right">{{$datas->ldr}}%</td>
                    <td align="right">-</td>
                    <td align="center">{{$p_persen_ldr}}%</td>
                </tr>
                <tr style="font-weight: bold">
                    <td style="text-align: left">Kredit yang Diberikan</td>
                    <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->kredit_diberikan)  @endif</td>
                    <td align="right">@currency($datas->kredit_diberikan)</td>
                    <td align="right">@currency($p_kreditdiberikan)</td>
                    <td align="center">{{ number_format((float)$p_persen_kreditdiberikan, 2, '.', '') }}%</td>
                </tr>
                <tr style="font-weight: bold">
                    <td style="text-align: left">Simpanan Pihak ke-III</td>
                    <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->simpanan_pihaktiga) @endif</td>
                    <td align="right">@currency($datas->simpanan_pihaktiga)</td>
                    <td align="right">@currency($p_simpananpihaktiga)</td>
                    <td align="center">{{ number_format((float)$p_persen_simpananpihaktiga, 2, '.', '') }}%</td>
                </tr>
                <tr>
                    <td style="text-align: left">&nbsp;&nbsp; - Deposito</td>
                    <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->deposito) @endif</td>
                    <td align="right">@currency($datas->deposito)</td>
                    <td align="right">@currency($p_deposito)</td>
                    <td align="center">{{ number_format((float)$p_persen_deposito, 2, '.', '') }}%</td>
                </tr>
                <tr>
                    <td style="text-align: left">&nbsp;&nbsp; - Tabungan</td>
                    <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->tabungan) @endif</td>
                    <td align="right">@currency($datas->tabungan)</td>
                    <td align="right">@currency($p_tabungan)</td>
                    <td align="center">{{ number_format((float)$p_persen_tabungan, 2, '.', '') }}%</td>
                </tr>
                <tr>
                    <td style="text-align: left">&nbsp;&nbsp; - Pinjaman Diterima</td>
                    <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->pinjaman_diterima) @endif</td>
                    <td align="right">@currency($datas->pinjaman_diterima)</td>
                    <td align="right">@currency($p_pinjamanditerima)</td>
                    <td align="center">{{ number_format((float)$p_persen_pinjamanditerima, 2, '.', '') }}%</td>
                </tr>
                <tr>
                    <td style="text-align: left">&nbsp;&nbsp; - Antar Bank Pasiva</td>
                    <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->antarbank_pasiva) @endif</td>
                    <td align="right">@currency($datas->antarbank_pasiva)</td>
                    <td align="right">@currency($p_antarbankpasiva)</td>
                    <td align="center">{{ number_format((float)$p_persen_antarbankpasiva, 2, '.', '') }}%</td>
                </tr>
                <tr>
                    <td style="text-align: left">&nbsp;&nbsp; - Modal Inti</td>
                    <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->modal_inti) @endif</td>
                    <td align="right">@currency($datas->modal_inti)</td>
                    <td align="right">@currency($p_modalinti)</td>
                    <td align="center">{{ number_format((float)$p_persen_modalinti, 2, '.', '') }}%</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection