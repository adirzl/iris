<table>
    <tr style="text-align: center">
        <th rowspan="2" style="width:350px">Indikator</th>
        <th rowspan="2" style="width:300px">{{$bulan[$now->bulan]}} - {{$now->tahun - 1}}</th>
        <th rowspan="2" style="width:300px">{{$bulan[$now->bulan]}} - {{$now->tahun}}</th>
        <th colspan="2" style="width:300px">Naik/Turun</th>
    </tr>
    <tr style="text-align: center">
        <th style="width:300px">Rp</th>
        <th style=" width:300px">%</th>
    </tr>
    <tr>
        <td style="text-align: left">BOPO</td>
        <td align="right">@if(is_null($lastyear)) - @else {{$lastyear->bopo}}% @endif</td>
        <td align="right">{{$now->bopo}}%</td>
        <td align="right">-</td>
        <td align="center">{{$p_persen_bopo}}%</td>
    </tr>
    <tr>
        <td style="text-align: left">Beban Operasional</td>
        <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->beban_operasional) @endif</td>
        <td align="right">@currency($now->beban_operasional)</td>
        <td align="right">@currency($p_bebanoperasional)</td>
        <td align="center">{{ number_format((float)$p_persen_bebanoperasional, 2, '.', '') }}%</td>
    </tr>
    <tr>
        <td style="text-align: left">Pendapatan Operasional</td>
        <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->pendapatan_operasional) @endif</td>
        <td align="right">@currency($now->pendapatan_operasional)</td>
        <td align="right">@currency($p_pendapatanoperasional)</td>
        <td align="center">{{ number_format((float)$p_persen_pendapatanoperasional, 2, '.', '') }}%</td>
    </tr>
</table>