<table>
    <tr style="text-align: center">
        <th rowspan="2" style="width:450px">Indikator</th>
        <th rowspan="2" style="width:300px">{{$bulan[$now->bulan]}} - {{$now->tahun - 1}}</th>
        <th rowspan="2" style="width:300px">{{$bulan[$now->bulan]}} - {{$now->tahun}}</th>
        <th colspan="2" style="width:300px">Naik/Turun</th>
    </tr>
    <tr style="text-align: center">
        <th style="width:300px">Rp</th>
        <th style=" width:300px">%</th>
    </tr>
    <tr>
        <td style="text-align: left">ROA</td>
        <td align="right">@if(is_null($lastyear)) - @else {{$lastyear->roa}}% @endif</td>
        <td align="right">{{$now->roa}}%</td>
        <td align="right">-</td>
        <td align="center">{{$p_persen_roa}}%</td>
    </tr>
    <tr>
        <td style="text-align: left">Aset (Rata-rata 12 Bulan Terakhir)</td>
        <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->aset) @endif</td>
        <td align="right">@currency($now->aset)</td>
        <td align="right">@currency($p_aset)</td>
        <td align="center">{{ number_format((float)$p_persen_aset, 2, '.', '') }}%</td>
    </tr>
    <tr>
        <td style="text-align: left">Laba Sebelum Pajak (Rata-rata 12 Bulan Terakhir)</td>
        <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->laba_sebelum_pajak) @endif</td>
        <td align="right">@currency($now->laba_sebelum_pajak)</td>
        <td align="right">@currency($p_labasebelumpajak)</td>
        <td align="center">{{ number_format((float)$p_persen_labasebelumpajak, 2, '.', '') }}%</td>
    </tr>
</table>