@extends('layouts.app')
@section('title', 'BOPO')
@section('content')
<div class="card">
    <div class="card-header">
        <a type="button" href="{{url('realisasi-rbb', $datas->id_realisasirbb)}}" class="btn btn-sm btn-flat btn-default"><i class="fa fa-arrow-circle-left"></i>&nbsp;&nbsp;Back</a>&nbsp;
        <a type="button" href="{{url('realisasi-rbb/export', $datas->id_realisasi_detail)}}"class="btn btn-sm btn-flat btn-success"><i class="fa fa-file-excel"></i>&nbsp;&nbsp;Export Excel</a>
    </div>
    <div class="card-body">
        <div class="col-xs-12">
            <table border="3">
                <tr style="text-align: center">
                    <th rowspan="2" style="width:350px; color: white; background-color:rgb(0, 0, 0)"">Indikator</th>
                    <th rowspan="2" style="width:300px; color: white; background-color:rgb(0, 0, 0)"">{{$bulan[$datas->bulan]}} - {{$datas->tahun - 1}}</th>
                    <th rowspan="2" style="width:300px; color: white; background-color:rgb(0, 0, 0)"">{{$bulan[$datas->bulan]}} - {{$datas->tahun}}</th>
                    <th colspan="2" style="width:300px; color: white; background-color:rgb(0, 0, 0)"">Naik/Turun</th>
                </tr>
                <tr style="text-align: center">
                    <th style="width:300px; color: white; background-color:rgb(0, 0, 0)"">Rp</th>
                    <th style=" width:300px; color: white; background-color:rgb(0, 0, 0)"">%</th>
                </tr>
                <tr>
                    <td style="text-align: left">BOPO</td>
                    <td align="right">@if(is_null($lastyear)) - @else {{$lastyear->bopo}}% @endif</td>
                    <td align="right">{{$datas->bopo}}%</td>
                    <td align="right">-</td>
                    <td align="center">{{$p_persen_bopo}}%</td>
                </tr>
                <tr>
                    <td style="text-align: left">Beban Operasional</td>
                    <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->beban_operasional) @endif</td>
                    <td align="right">@currency($datas->beban_operasional)</td>
                    <td align="right">@currency($p_bebanoperasional)</td>
                    <td align="center">{{ number_format((float)$p_persen_bebanoperasional, 2, '.', '') }}%</td>
                </tr>
                <tr>
                    <td style="text-align: left">Pendapatan Operasional</td>
                    <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->pendapatan_operasional) @endif</td>
                    <td align="right">@currency($datas->pendapatan_operasional)</td>
                    <td align="right">@currency($p_pendapatanoperasional)</td>
                    <td align="center">{{ number_format((float)$p_persen_pendapatanoperasional, 2, '.', '') }}%</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection