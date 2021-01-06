<table>
    <tr style="text-align: center">
        <th rowspan="3" style="width:300px">Keterangan</th>
        <th rowspan="3" style="width:250px">{{$bulan[$now->bulan]}} - {{$now->tahun - 1}}</th>
        <th rowspan="3" style="width:250px">{{$bulan[$now->bulan]}} - {{$now->tahun}}</th>
        <th colspan="2" style="width:500px">Naik / Turun</th>
    </tr>
    <tr style="text-align: center">
        <th colspan="2" style="width:200px">YoY</th>
    </tr>
    <tr style="text-align: center">
        <th style="width:200px">Rp</th>
        <th style="width:200px">%</th>
    </tr>
    <tr style="font-weight: bold; text-align: left">
        <td>Cash Rasio</td>
        <td align="right">@if(is_null($lastyear)) - @else {{$lastyear->cash_rasio}}% @endif</td>
        <td align="right">{{$now->cash_rasio}}%</td>
        <td align="right">-</td>
        <td align="center">{{$p_persen_cashrasio}}%</td>
    </tr>
    <tr style="font-weight: bold; text-align: left">
        <td>Alat Likuid</td>
        <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->alat_liquid) @endif</td>
        <td align="right">@currency($now->alat_liquid)</td>
        <td align="right">@currency($p_alatliquid)</td>
        <td align="center">{{ number_format((float)$p_persen_alatliquid, 2, '.', '') }}%</td>
    </tr>
    <tr style="text-align: left">
        <td>&nbsp;&nbsp; - Kas</td>
        <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->kas) @endif</td>
        <td align="right">@currency($now->kas)</td>
        <td align="right">@currency($p_kas)</td>
        <td align="center">{{ number_format((float)$p_persen_kas, 2, '.', '') }}%</td>
    </tr>
    <tr style="text-align: left">
        <td>&nbsp;&nbsp; - Giro</td>
        <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->giro) @endif</td>
        <td align="right">@currency($now->giro)</td>
        <td align="right">@currency($p_giro)</td>
        <td align="center">{{ number_format((float)$p_persen_giro, 2, '.', '') }}%</td>
    </tr>
    <tr style="text-align: left">
        <td>&nbsp;&nbsp; - Tabungan</td>
        <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->tabungan) @endif</td>
        <td align="right">@currency($now->tabungan)</td>
        <td align="right">@currency($p_tabungan)</td>
        <td align="center">{{ number_format((float)$p_persen_tabungan, 2, '.', '') }}%</td>
    </tr>
    <tr style="font-weight: bold; text-align: left">
        <td>Hutang Lancar</td>
        <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->hutang_lancar) @endif</td>
        <td align="right">@currency($now->hutang_lancar)</td>
        <td align="right">@currency($p_hutanglancar)</td>
        <td align="center">{{ number_format((float)$p_persen_hutanglancar, 2, '.', '') }}%</td>
    </tr>
    <tr style="text-align: left">
        <td>&nbsp;&nbsp; - Kewajiban Segera</td>
        <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->kewajiban_segera) @endif</td>
        <td align="right">@currency($now->kewajiban_segera)</td>
        <td align="right">@currency($p_kewajibansegera)</td>
        <td align="center">{{ number_format((float)$p_persen_kewajibansegera, 2, '.', '') }}%</td>
    </tr>
    <tr style="text-align: left">
        <td>&nbsp;&nbsp; - Hutang Bunga dan Pajak</td>
        <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->hutang_bungapajak) @endif</td>
        <td align="right">@currency($now->hutang_bungapajak)</td>
        <td align="right">@if(is_null($lastyear)) - @else @currency($p_hutang_bungapajak) @endif</td>
        <td align="center">@if(is_null($lastyear)) - @else {{ number_format((float)$p_persen_hutangbungapajak, 2, '.', '') }}% @endif</td>
    </tr>
    <tr style="text-align: left">
        <td>&nbsp;&nbsp; - Deposito</td>
        <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->deposito) @endif</td>
        <td align="right">@currency($now->deposito)</td>
        <td align="right">@currency($p_deposito)</td>
        <td align="center">{{ number_format((float)$p_persen_deposito, 2, '.', '') }}%</td>
    </tr>
    <tr style="text-align: left">
        <td>&nbsp;&nbsp; - Tabungan</td>
        <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->Tabungan) @endif</td>
        <td align="right">@currency($now->Tabungan)</td>
        <td align="right">@currency($p_Tabungan)</td>
        <td align="center">{{ number_format((float)$p_persen_Tabungan, 2, '.', '') }}%</td>
    </tr>
</table><br>