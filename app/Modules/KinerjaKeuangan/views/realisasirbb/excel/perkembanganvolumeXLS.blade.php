<table>
    <tr style="text-align: center">
        <th rowspan="2">Indikator</th>
        <th rowspan="2">{{$bulan[$now->bulan]}} - {{$now->tahun-1}}</th>
        <th rowspan="2">{{$bulan[$now->bulan]}} - {{$now->tahun}}</th>
        <th rowspan="2">Target <br>{{$bulan[$now->bulan]}} {{$now->tahun}}</th>
        <th colspan="2">Pertumbuhan YoY</th>
        <th rowspan="2">Pencapaian RBB</th>
    </tr>
    <tr style=" text-align: center">
        <th>Rp</th>
        <th>%</th>
    </tr>
    <tr style="font-weight: bold; text-align: center">
        <td style="text-align: left">Total Aset</td>
        <td align="right">@if(is_null($last)) - @else @currency($last->total_aset) @endif</td>
        <td align="right">@currency($now->total_aset)</td>
        <td align="right">@if(is_null($target)) - @else @currency($target->total_aset * 1000000) @endif</td>
        @if($p_aset < 0) 
        <td align="right">(@currency($p_aset))</td>
        @else
        <td align="right">@currency($p_aset)</td>
        @endif
        <td>{{$p_persen_aset}}%</td>
        <td>{{$p_aset_penc}}%</td>
    </tr>
    <tr>
        <td style="font-weight: bold">Penyaluran Dana:</td>
        <td colspan="6"></td>
    </tr>
    <tr style="text-align: center">
        <td style="text-align: left">&nbsp;&nbsp;- Total ABA</td>
        <td align="right">@if(is_null($last)) - @else @currency($last->total_aba) @endif</td>
        <td align="right">@currency($now->total_aba)</td>
        <td align="right">@if(is_null($target)) - @else @currency($target->total_aba * 1000000) @endif</td>
        @if($p_aba < 0) <td align="right">(@currency($p_aba))</td>
        @else
        <td align="right">@currency($p_aba)</td>
        @endif
        <td>{{$p_persen_aba}}%</td>
        <td>{{$p_aba_penc}}%</td>
    </tr>
    <tr style="text-align: center">
        <td style="text-align: left">&nbsp;&nbsp;- Total Kredit</td>
        <td align="right">@if(is_null($last)) - @else @currency($last->total_kredit) @endif</td>
        <td align="right">@currency($now->total_kredit)</td>
        <td align="right">@if(is_null($target)) - @else @currency($target->total_kredit * 1000000) @endif</td>
        @if($p_kredit < 0) <td align="right">(@currency($p_kredit))</td>
        @else
        <td align="right">@currency($p_kredit)</td>
        @endif
        <td>{{$p_persen_kredit}}%</td>
        <td>{{$p_kredit_penc}}%</td>
    </tr>
    <tr>
        <td style="font-weight: bold">Sumber Dana:</td>
        <td colspan="6"></td>
    </tr>
    <tr style="font-weight: bold; text-align: center">
        <td style="text-align: left">Dana Pihak Ketiga</td>
        <td align="right">@if(is_null($last)) - @else @currency($last->dana_pihaktiga) @endif</td>
        <td align="right">@currency($now->dana_pihaktiga)</td>
        <td align="right">@if(is_null($target)) - @else @currency($target->dana_pihak_ketiga * 1000000) @endif</td>
        @if($p_dana_pihaktiga < 0) <td align="right">(@currency($p_dana_pihaktiga))</td>
        @else
        <td align="right">@currency($p_dana_pihaktiga)</td>
        @endif
        <td>{{$p_persen_dana_pihaktiga}}%</td>
        <td>{{$p_dpk_penc}}%</td>
    </tr>
    <tr style="text-align: center">
        <td style="text-align: left">&nbsp;&nbsp;- Tabungan</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr>
    <tr style="text-align: center">
        <td style="text-align: left">&nbsp;&nbsp;- Deposito</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr>
    <tr style="text-align: center">
        <td style="text-align: left">Pinjaman Yang Diterima</td>
        <td align="right">@if(is_null($last)) - @else @currency($last->pinjaman_diterima) @endif</td>
        <td align="right">@currency($now->pinjaman_diterima)</td>
        <td align="right">@if(is_null($target)) - @else @currency($target->pinjaman_yang_diterima * 1000000) @endif</td>
        @if($p_pinjaman_diterima < 0) <td align="right">(@currency($p_pinjaman_diterima))</td>
        @else
        <td align="right">@currency($p_pinjaman_diterima)</td>
        @endif
        <td>{{$p_persen_pinjaman_diterima}}%</td>
        <td>{{$p_pindit_penc}}%</td>
    </tr>
    <tr style="text-align: center">
        <td style="text-align: left">Antar Bank Pasiva</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr>
    <tr style="font-weight: bold; text-align: center">
        <td style="text-align: left">Modal Disetor</td>
        <td align="right">@if(is_null($last)) - @else @currency($last->modal) @endif</td>
        <td align="right">@currency($now->modal)</td>
        <td align="right">@if(is_null($target)) - @else @currency($target->modal * 1000000) @endif</td>
        @if($p_modal < 0) <td align="right">(@currency($p_modal))</td>
        @else
        <td align="right">@currency($p_modal)</td>
        @endif
        <td>{{$p_persen_modal}}%</td>
        <td>{{$p_modal_penc}}%</td>
    </tr>
    <tr style="font-weight: bold; text-align: center">
        <td style="text-align: left">Laba / Rugi Tahun Berjalan</td>
        <td align="right">@if(is_null($last)) - @else @currency($last->laba_rugi) @endif</td>
        <td align="right">@currency($now->laba_rugi)</td>
        <td align="right">@if(is_null($target)) - @else @currency($target->laba_rugi * 1000000) @endif</td>
        @if($p_laba_rugi < 0) <td align="right">(@currency($p_laba_rugi))</td>
        @else
        <td align="right">@currency($p_laba_rugi)</td>
        @endif
        <td>{{$p_persen_laba_rugi}}%</td>
        <td>{{$p_laba_rugi_penc}}%</td>
    </tr>
</table><br>