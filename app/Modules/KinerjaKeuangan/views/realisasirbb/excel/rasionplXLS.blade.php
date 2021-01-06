<table>
    <tr style="text-align: center">
        <th rowspan="3" style="width:200px">Indikator</th>
        <th rowspan="2" colspan="3" style="width:200px">Periode</th>
        <th colspan="4" style="width:300px">Pertumbuhan</th>
    </tr>
    <tr style=" text-align: center">
        {{-- <th colspan="3" style="width:200px; background-color:goldenrod""></th> --}}
        <th colspan="2" style="width:200px">Monthly</th>
        <th colspan="2"style="width:200px">YoY</th>
    </tr>
    <tr style=" text-align: center">
        <th style="width:200px">{{$bulan[$now->bulan]}} - {{$now->tahun - 1}}</th>
        <th style="width:200px">@if($now->bulan == 1) {{$bulan[$now->bulan]}} - {{$now->tahun}} @else {{$bulan[$now->bulan - 1]}} - {{$now->tahun}} @endif</th>
        <th style="width:200px">{{$bulan[$now->bulan]}} - {{$now->tahun}}</th>
        <th style="width:200px">Rp</th>
        <th style="width:200px">%</th>
        <th style="width:200px">Rp</th>
        <th style="width:200px">%</th>
    </tr>
    <tr style=" text-align: center">
        <td style="text-align: left">Lancar</td>
        <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->lancar) @endif</td>
        <td align="right">@if(is_null($lastmonth)) - @else @currency($lastmonth->lancar) @endif</td>
        <td align="right">@currency($now->lancar)</td>
        <td align="right">@currency($p_lancar_month)</td>
        <td>{{ number_format((float)$p_persen_lancarmonth, 2, '.', '') }}%</td>
        <td align="right">@currency($p_lancar_year)</td>
        <td>{{ number_format((float)$p_persen_lancaryear, 2, '.', '') }}%</td>
    </tr>
    <tr style="text-align: center">
        <td style="text-align: left">Dalam Perhatian Khusus</td>
        <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->dalam_perhatian) @endif</td>
        <td align="right">@if(is_null($lastmonth)) - @else @currency($lastmonth->dalam_perhatian) @endif</td>
        <td align="right">@currency($now->dalam_perhatian)</td>
        <td align="right">@currency($p_dalamperhatian_month)</td>
        <td align="right"></td>
        <td align="right">@currency($p_dalamperhatian_year)</td>
        <td></td>
    </tr>
    <tr style="text-align: center">
        <td style="text-align: left">Kurang Lancar</td>
        <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->kurang_lancar) @endif</td>
        <td align="right">@if(is_null($lastmonth)) - @else @currency($lastmonth->kurang_lancar) @endif</td>
        <td align="right">@currency($now->kurang_lancar)</td>
        <td align="right">@currency($p_kuranglancar_month)</td>
        <td>{{ number_format((float)$p_persen_kuranglancarmonth, 2, '.', '') }}%</td>
        <td align="right">@currency($p_kuranglancar_year)</td>
        <td>{{ number_format((float)$p_persen_kuranglancaryear, 2, '.', '') }}%</td>
    </tr>
    <tr style="text-align: center">
        <td style="text-align: left">Diragukan</td>
        <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->diragukan) @endif</td>
        <td align="right">@if(is_null($lastmonth)) - @else @currency($lastmonth->diragukan) @endif</td>
        <td align="right">@currency($now->diragukan)</td>
        <td align="right">@currency($p_diragukan_month)</td>
        <td>{{ number_format((float)$p_persen_diragukanmonth, 2, '.', '') }}%</td>
        <td align="right">@currency($p_diragukan_year)</td>
        <td>{{ number_format((float)$p_persen_diragukanyear, 2, '.', '') }}%</td>
    </tr>
    <tr style="text-align: center">
        <td style="text-align: left">Macet</td>
        <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->macet) @endif</td>
        <td align="right">@if(is_null($lastmonth)) - @else @currency($lastmonth->macet) @endif</td>
        <td align="right">@currency($now->macet)</td>
        <td align="right">@currency($p_macet_month)</td>
        <td>{{ number_format((float)$p_persen_macetmonth, 2, '.', '') }}%</td>
        <td align="right">@currency($p_macet_year)</td>
        <td>{{ number_format((float)$p_persen_macetyear, 2, '.', '') }}%</td>
    </tr>
    <tr style="font-weight: bold; text-align: center">
        <td>Total</td>
        <td align="right">@currency($totalastyear)</td>
        <td align="right">@currency($totalastmonth)</td>
        <td align="right">@currency($total)</td>
        <td align="right">@currency($total_pertumbuhan_month)</td>
        <td>{{ number_format((float)$p_persen_totalmonth, 2, '.', '') }}%</td>
        <td align="right">@currency($total_pertumbuhan_year)</td>
        <td>{{ number_format((float)$p_persen_totalyear, 2, '.', '') }}%</td>
    </tr>
    <tr style="text-align: center">
        <td>Total Kredit Non Lancar</td>
        <td align="right">@currency($totalnonlancar_lastyear)</td>
        <td align="right">@currency($totalnonlancar_lastmonth)</td>
        <td align="right">@currency($totalnonlancar)</td>
        <td align="right">@currency($total_nonlancarmonth)</td>
        <td align="right"></td>
        <td align="right">@currency($total_nonlancaryear)</td>
        <td></td>
    </tr>
    <tr style="text-align: center">
        <td>Rasio NPL Gross</td>
        <td align="right">@if(is_null($lastyear)) - @else {{$lastyear->rasio_npl_gross}}% @endif</td>
        <td align="right">@if(is_null($lastmonth)) - @else {{$lastmonth->rasio_npl_gross}}% @endif</td>
        <td align="right">{{$now->rasio_npl_gross}}%</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td></td>
    </tr>
</table>