@extends('layouts.app')
@section('title', 'ROA')
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
                    <th rowspan="2" style="width:450px; color: white; background-color:rgb(0, 0, 0)"">Indikator</th>
                    <th rowspan="2" style="width:300px; color: white; background-color:rgb(0, 0, 0)"">{{$bulan[$datas->bulan]}} - {{$datas->tahun - 1}}</th>
                    <th rowspan="2" style="width:300px; color: white; background-color:rgb(0, 0, 0)"">{{$bulan[$datas->bulan]}} - {{$datas->tahun}}</th>
                    <th colspan="2" style="width:300px; color: white; background-color:rgb(0, 0, 0)"">Naik/Turun</th>
                </tr>
                <tr style="text-align: center">
                    <th style="width:300px; color: white; background-color:rgb(0, 0, 0)"">Rp</th>
                    <th style=" width:300px; color: white; background-color:rgb(0, 0, 0)"">%</th>
                </tr>
                <tr>
                    <td style="text-align: left">ROA</td>
                    <td align="right">@if(is_null($lastyear)) - @else {{$lastyear->roa}}% @endif</td>
                    <td align="right">{{$datas->roa}}%</td>
                    <td align="right">-</td>
                    <td align="center">{{$p_persen_roa}}%</td>
                </tr>
                <tr>
                    <td style="text-align: left">Aset (Rata-rata 12 Bulan Terakhir)</td>
                    <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->aset) @endif</td>
                    <td align="right">@currency($datas->aset)</td>
                    <td align="right">@currency($p_aset)</td>
                    <td align="center">{{ number_format((float)$p_persen_aset, 2, '.', '') }}%</td>
                </tr>
                <tr>
                    <td style="text-align: left">Laba Sebelum Pajak (Rata-rata 12 Bulan Terakhir)</td>
                    <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->laba_sebelum_pajak) @endif</td>
                    <td align="right">@currency($datas->laba_sebelum_pajak)</td>
                    <td align="right">@currency($p_labasebelumpajak)</td>
                    <td align="center">{{ number_format((float)$p_persen_labasebelumpajak, 2, '.', '') }}%</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection