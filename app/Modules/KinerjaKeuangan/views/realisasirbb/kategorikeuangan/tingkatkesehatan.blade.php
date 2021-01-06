@extends('layouts.app')
@section('title', 'Tingkat Kesehatan Bank')
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
                    <th rowspan="2" style="width:450px; color: white; background-color:rgb(0, 0, 0)"">C A M E L</th>
                    <th colspan="2" style="width:300px; color: white; background-color:rgb(0, 0, 0)"">{{$bulan[$datas->bulan]}} - {{$datas->tahun - 1}}</th>
                    <th colspan="2" style="width:300px; color: white; background-color:rgb(0, 0, 0)"">{{$bulan[$datas->bulan]}} - {{$datas->tahun}}</th>
                </tr>
                <tr style="text-align: center">
                    <th style="width:300px; color: white; background-color:rgb(0, 0, 0)"">Nilai</th>
                    <th style=" width:300px; color: white; background-color:rgb(0, 0, 0)"">Bobot</th>
                    <th style="width:300px; color: white; background-color:rgb(0, 0, 0)"">Nilai</th>
                    <th style=" width:300px; color: white; background-color:rgb(0, 0, 0)"">Bobot</th>
                </tr>
                <tr>
                    <td style="text-align: left">CAR</td>
                    <td align="center">@if(is_null($lastyear)) - @else {{$lastyear->nilai_car}}% @endif</td>
                    <td align="center">@if(is_null($lastyear)) - @else {{$lastyear->bobot_car}} @endif</td>
                    <td align="center">{{$datas->nilai_car}}%</td>
                    <td align="center">{{$datas->bobot_car}}</td>
                </tr>
                <tr>
                    <td style="text-align: left">KAP</td>
                    <td align="center">@if(is_null($lastyear)) - @else {{$lastyear->nilai_kap}}% @endif</td>
                    <td align="center">@if(is_null($lastyear)) - @else {{$lastyear->bobot_kap}} @endif</td>
                    <td align="center">{{$datas->nilai_car}}%</td>
                    <td align="center">{{$datas->bobot_car}}</td>
                </tr>
                <tr>
                    <td style="text-align: left">PPAP</td>
                    <td align="center">@if(is_null($lastyear)) - @else {{$lastyear->nilai_ppap}}% @endif</td>
                    <td align="center">@if(is_null($lastyear)) - @else {{$lastyear->bobot_ppap}} @endif</td>
                    <td align="center">{{$datas->nilai_ppap}}%</td>
                    <td align="center">{{$datas->bobot_ppap}}</td>
                </tr>
                <tr>
                    <td style="text-align: left">CR</td>
                    <td align="center">@if(is_null($lastyear)) - @else {{$lastyear->nilai_cr}}% @endif</td>
                    <td align="center">@if(is_null($lastyear)) - @else {{$lastyear->bobot_cr}} @endif</td>
                    <td align="center">{{$datas->nilai_cr}}%</td>
                    <td align="center">{{$datas->bobot_cr}}</td>
                </tr>
                <tr>
                    <td style="text-align: left">LDR</td>
                    <td align="center">@if(is_null($lastyear)) - @else {{$lastyear->nilai_ldr}}% @endif</td>
                    <td align="center">@if(is_null($lastyear)) - @else {{$lastyear->bobot_ldr}} @endif</td>
                    <td align="center">{{$datas->nilai_ldr}}%</td>
                    <td align="center">{{$datas->bobot_ldr}}</td>
                </tr>
                <tr>
                    <td style="text-align: left">ROA</td>
                    <td align="center">@if(is_null($lastyear)) - @else {{$lastyear->nilai_roa}}% @endif</td>
                    <td align="center">@if(is_null($lastyear)) - @else {{$lastyear->bobot_roa}} @endif</td>
                    <td align="center">{{$datas->nilai_roa}}%</td>
                    <td align="center">{{$datas->bobot_roa}}</td>
                </tr>
                <tr>
                    <td style="text-align: left">BOPO</td>
                    <td align="center">@if(is_null($lastyear)) - @else {{$lastyear->nilai_bopo}}% @endif</td>
                    <td align="center">@if(is_null($lastyear)) - @else {{$lastyear->bobot_bopo}} @endif</td>
                    <td align="center">{{$datas->nilai_bopo}}%</td>
                    <td align="center">{{$datas->bobot_bopo}}</td>
                </tr>
                <tr style="font-weight: bold">
                    <td align="center">MANAJEMEN</td>
                    <td align="center" style="color: white; background-color:rgb(0, 0, 0)""></td>
                    <td align="center">@if(is_null($lastyear)) - @else {{$lastyear->manajemen_umum}} @endif</td>
                    <td align="center" style="color: white; background-color:rgb(0, 0, 0)""></td>
                    <td align="center">{{$datas->manajemen_umum}}</td>
                </tr>
                <tr style="font-weight: bold; color: white; background-color:rgb(0, 0, 0)"">
                    <td align="center">Total Nilai Reward</td>
                    <td align="center"></td>
                    <td align="center">@if(is_null($lastyear)) - @else {{$total_reward_last}} @endif</td>
                    <td align="center"></td>
                    <td align="center"> {{$total_reward_current}}</td>
                </tr>
                <tr style="font-weight: bold; color: white; background-color:rgb(0, 0, 0)"">
                    <td align="center">Tingkat Kesehatan</td>
                    <td align="center" colspan="2">
                        @if($total_reward_last >= 81) Sehat 
                        @elseif($total_reward_last < 81 && $total_reward_last >= 66) Cukup Sehat
                        @elseif($total_reward_last < 66 && $total_reward_last >= 51) Kurang Sehat
                        @else Tidak Sehat
                        @endif
                    </td>
                    <td align="center" colspan="2">
                        @if($total_reward_current >= 81) Sehat 
                        @elseif($total_reward_current < 81 && $total_reward_current >= 66) Cukup Sehat
                        @elseif($total_reward_current < 66 && $total_reward_current >= 51) Kurang Sehat
                        @else Tidak Sehat
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection