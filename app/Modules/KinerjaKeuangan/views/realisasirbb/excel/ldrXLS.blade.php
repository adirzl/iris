<table>
    <tr style="text-align: center">
        <th rowspan="2" style="width:350px">Keterangan</th>
        <th rowspan="2" style="width:200px">{{$bulan[$now->bulan]}} - {{$now->tahun - 1}}</th>
        <th rowspan="2" style="width:200px">{{$bulan[$now->bulan]}} - {{$now->tahun}}</th>
        <th colspan="2" style="width:300px">Naik/Turun</th>
    </tr>
    <tr style="text-align: center">
        <th style="width:200px">Rp</th>
        <th style=" width:200px">%</th>
    </tr>
    <tr style="font-weight: bold; text-align: center">
        <td style="text-align: left">LDR</td>
        <td align="right">@if(is_null($lastyear)) - @else {{$lastyear->ldr}}% @endif</td>
        <td align="right">{{$now->ldr}}%</td>
        <td align="right">-</td>
        <td align="center">{{$p_persen_ldr}}%</td>
    </tr>
    <tr style="font-weight: bold">
        <td style="text-align: left">Kredit yang Diberikan</td>
        <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->kredit_diberikan)  @endif</td>
        <td align="right">@currency($now->kredit_diberikan)</td>
        <td align="right">@currency($p_kreditdiberikan)</td>
        <td align="center">{{ number_format((float)$p_persen_kreditdiberikan, 2, '.', '') }}%</td>
    </tr>
    <tr style="font-weight: bold">
        <td style="text-align: left">Simpanan Pihak ke-III</td>
        <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->simpanan_pihaktiga) @endif</td>
        <td align="right">@currency($now->simpanan_pihaktiga)</td>
        <td align="right">@currency($p_simpananpihaktiga)</td>
        <td align="center">{{ number_format((float)$p_persen_simpananpihaktiga, 2, '.', '') }}%</td>
    </tr>
    <tr>
        <td style="text-align: left">&nbsp;&nbsp; - Deposito</td>
        <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->deposito) @endif</td>
        <td align="right">@currency($now->deposito)</td>
        <td align="right">@currency($p_deposito)</td>
        <td align="center">{{ number_format((float)$p_persen_deposito, 2, '.', '') }}%</td>
    </tr>
    <tr>
        <td style="text-align: left">&nbsp;&nbsp; - Tabungan</td>
        <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->tabungan) @endif</td>
        <td align="right">@currency($now->tabungan)</td>
        <td align="right">@currency($p_tabungan)</td>
        <td align="center">{{ number_format((float)$p_persen_tabungan, 2, '.', '') }}%</td>
    </tr>
    <tr>
        <td style="text-align: left">&nbsp;&nbsp; - Pinjaman Diterima</td>
        <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->pinjaman_diterima) @endif</td>
        <td align="right">@currency($now->pinjaman_diterima)</td>
        <td align="right">@currency($p_pinjamanditerima)</td>
        <td align="center">{{ number_format((float)$p_persen_pinjamanditerima, 2, '.', '') }}%</td>
    </tr>
    <tr>
        <td style="text-align: left">&nbsp;&nbsp; - Antar Bank Pasiva</td>
        <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->antarbank_pasiva) @endif</td>
        <td align="right">@currency($now->antarbank_pasiva)</td>
        <td align="right">@currency($p_antarbankpasiva)</td>
        <td align="center">{{ number_format((float)$p_persen_antarbankpasiva, 2, '.', '') }}%</td>
    </tr>
    <tr>
        <td style="text-align: left">&nbsp;&nbsp; - Modal Inti</td>
        <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->modal_inti) @endif</td>
        <td align="right">@currency($now->modal_inti)</td>
        <td align="right">@currency($p_modalinti)</td>
        <td align="center">{{ number_format((float)$p_persen_modalinti, 2, '.', '') }}%</td>
    </tr>
</table>