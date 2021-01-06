<table border="3">
    <tr style="text-align: center">
        <th rowspan="2" style="width:450px">C A M E L</th>
        <th colspan="2" style="width:300px">{{$bulan[$now->bulan]}} - {{$now->tahun - 1}}</th>
        <th colspan="2" style="width:300px">{{$bulan[$now->bulan]}} - {{$now->tahun}}</th>
    </tr>
    <tr style="text-align: center">
        <th style="width:300px">Nilai</th>
        <th style=" width:300px">Bobot</th>
        <th style="width:300px">Nilai</th>
        <th style=" width:300px">Bobot</th>
    </tr>
    <tr>
        <td style="text-align: left">CAR</td>
        <td align="center">@if(is_null($lastyear)) - @else {{$lastyear->nilai_car}}% @endif</td>
        <td align="center">@if(is_null($lastyear)) - @else {{$lastyear->bobot_car}} @endif</td>
        <td align="center">{{$now->nilai_car}}%</td>
        <td align="center">{{$now->bobot_car}}</td>
    </tr>
    <tr>
        <td style="text-align: left">KAP</td>
        <td align="center">@if(is_null($lastyear)) - @else {{$lastyear->nilai_kap}}% @endif</td>
        <td align="center">@if(is_null($lastyear)) - @else {{$lastyear->bobot_kap}} @endif</td>
        <td align="center">{{$now->nilai_car}}%</td>
        <td align="center">{{$now->bobot_car}}</td>
    </tr>
    <tr>
        <td style="text-align: left">PPAP</td>
        <td align="center">@if(is_null($lastyear)) - @else {{$lastyear->nilai_ppap}}% @endif</td>
        <td align="center">@if(is_null($lastyear)) - @else {{$lastyear->bobot_ppap}} @endif</td>
        <td align="center">{{$now->nilai_ppap}}%</td>
        <td align="center">{{$now->bobot_ppap}}</td>
    </tr>
    <tr>
        <td style="text-align: left">CR</td>
        <td align="center">@if(is_null($lastyear)) - @else {{$lastyear->nilai_cr}}% @endif</td>
        <td align="center">@if(is_null($lastyear)) - @else {{$lastyear->bobot_cr}} @endif</td>
        <td align="center">{{$now->nilai_cr}}%</td>
        <td align="center">{{$now->bobot_cr}}</td>
    </tr>
    <tr>
        <td style="text-align: left">LDR</td>
        <td align="center">@if(is_null($lastyear)) - @else {{$lastyear->nilai_ldr}}% @endif</td>
        <td align="center">@if(is_null($lastyear)) - @else {{$lastyear->bobot_ldr}} @endif</td>
        <td align="center">{{$now->nilai_ldr}}%</td>
        <td align="center">{{$now->bobot_ldr}}</td>
    </tr>
    <tr>
        <td style="text-align: left">ROA</td>
        <td align="center">@if(is_null($lastyear)) - @else {{$lastyear->nilai_roa}}% @endif</td>
        <td align="center">@if(is_null($lastyear)) - @else {{$lastyear->bobot_roa}} @endif</td>
        <td align="center">{{$now->nilai_roa}}%</td>
        <td align="center">{{$now->bobot_roa}}</td>
    </tr>
    <tr>
        <td style="text-align: left">BOPO</td>
        <td align="center">@if(is_null($lastyear)) - @else {{$lastyear->nilai_bopo}}% @endif</td>
        <td align="center">@if(is_null($lastyear)) - @else {{$lastyear->bobot_bopo}} @endif</td>
        <td align="center">{{$now->nilai_bopo}}%</td>
        <td align="center">{{$now->bobot_bopo}}</td>
    </tr>
    <tr style="font-weight: bold">
        <td align="center">MANAJEMEN</td>
        <td align="center"></td>
        <td align="center">@if(is_null($lastyear)) - @else {{$lastyear->manajemen_umum}} @endif</td>
        <td align="center"></td>
        <td align="center">{{$now->manajemen_umum}}</td>
    </tr>
    <tr style="font-weight: bold">
        <td align="center">Total Nilai Reward</td>
        <td align="center"></td>
        <td align="center">@if(is_null($lastyear)) - @else {{$total_reward_last}} @endif</td>
        <td align="center"></td>
        <td align="center"> {{$total_reward_current}}</td>
    </tr>
    <tr style="font-weight: bold">
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