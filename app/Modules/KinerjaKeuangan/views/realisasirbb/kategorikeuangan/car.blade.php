@extends('layouts.app')
@section('title', 'Capital Adecuacy Ratio')
@section('content')
<div class="card">
    <div class="card-header">
        <a type="button" href="{{url('realisasi-rbb', $now->id_realisasirbb)}}" class="btn btn-sm btn-flat btn-default"><i class="fa fa-arrow-circle-left"></i>&nbsp;&nbsp;Back</a>&nbsp;
        <a type="button" href="{{url('realisasi-rbb/export', $now->id_realisasi_detail)}}" class="btn btn-sm btn-flat btn-success"><i class="fa fa-file-excel"></i>&nbsp;&nbsp;Export Excel</a>
    </div>
    <div class="card-body">
        <div class="col-xs-12">
            <table border="3">
                <tr style="text-align: center">
                    <th rowspan="2" style="width:350px; color: white; background-color:rgb(0, 0, 0)"">Indikator</th>
                    <th rowspan="2" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">{{$bulan[$now->bulan]}} - {{$now->tahun-1}}</th>
                    <th rowspan="2" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">{{$bulan[$now->bulan]}} - {{$now->tahun}}</th>
                    <th colspan="2" style="width:300px; color: white; background-color:rgb(0, 0, 0)"">Naik/Turun</th>
                </tr>
                <tr style="text-align: center">
                    <th style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Rp</th>
                    <th style=" width:200px; color: white; background-color:rgb(0, 0, 0)"">%</th>
                </tr>
                <tr style="font-weight: bold; text-align: center">
                    <td style="text-align: left">ATMR</td>
                    <td align="right">@if(is_null($last)) - @else @currency($last->ATMR) @endif</td>
                    <td align="right">@currency($now->ATMR)</td>
                    <td>@currency($p_atmr)</td>
                    <td>@if(is_null($last)) - @else {{$p_persen_atmr}}% @endif</td>
                </tr>
                <tr style="text-align: center">
                    <td style="text-align: left">&nbsp;&nbsp;- Antar Bank Aktiva</td>
                    <td align="right">@if(is_null($last)) - @else  @currency($last->antarbank_aktiva) @endif</td>
                    <td align="right">@currency($now->antarbank_aktiva)</td>
                    <td>@currency($p_antarbank_aktiva)</td>
                    <td>@if(is_null($last)) - @else {{$p_persen_antarbank_aktiva}}% @endif</td>
                </tr>
                <tr style="text-align: center">
                    <td style="text-align: left">&nbsp;&nbsp;- Kredit yang diberikan</td>
                    <td align="right">@if(is_null($last)) - @else  @currency($last->kredit_diberikan) @endif</td>
                    <td align="right">@currency($now->kredit_diberikan)</td>
                    <td>@currency($p_kredit_diberikan)</td>
                    <td>@if(is_null($last)) - @else {{$p_persen_kredit_diberikan}}% @endif</td>
                </tr>
                <tr style="text-align: center">
                    <td style="text-align: left">&nbsp;&nbsp;- ATI</td>
                    <td align="right">@if(is_null($last)) - @else  @currency($last->ATI) @endif</td>
                    <td align="right">@currency($now->ATI)</td>
                    <td>@currency($p_ati)</td>
                    <td>@if(is_null($last)) - @else {{$p_persen_ati}}% @endif</td>
                </tr>
                <tr style="text-align: center">
                    <td style="text-align: left">&nbsp;&nbsp;- Rupa-rupa Aktiva</td>
                    <td align="right">@if(is_null($last)) - @else  @currency($last->rupa_aktiva) @endif</td>
                    <td align="right">@currency($now->rupa_aktiva)</td>
                    <td>@currency($p_rupa_aktiva)</td>
                    <td>@if(is_null($last)) - @else {{$p_persen_rupa_aktiva}}% @endif</td>
                </tr>
                <tr style="font-weight: bold; text-align: center">
                    <td style="text-align: left">Modal Bank</td>
                    <td align="right">@if(is_null($last)) - @else  @currency($last->modal) @endif</td>
                    <td align="right">@currency($now->modal)</td>
                    <td>@currency($p_modal)</td>
                    <td>@if(is_null($last)) - @else {{$p_persen_modal}}% @endif</td>
                </tr>
                <tr style="text-align: center">
                    <td style="text-align: left">&nbsp;&nbsp;- Modal Disetor</td>
                    <td align="right">@if(is_null($last)) - @else  @currency($last->modal_disetor) @endif</td>
                    <td align="right">@currency($now->modal_disetor)</td>
                    <td>@currency($p_modal_disetor)</td>
                    <td>@if(is_null($last)) - @else {{$p_persen_modal_disetor}}% @endif</td>
                </tr>
                <tr style="text-align: center">
                    <td style="text-align: left">&nbsp;&nbsp;- Cadangan Umum</td>
                    <td align="right">@if(is_null($last)) - @else  @currency($last->cadangan_umum) @endif</td>
                    <td align="right">@currency($now->cadangan_umum)</td>
                    <td>@currency($p_cadangan_umum)</td>
                    <td>@if(is_null($last)) - @else {{$p_persen_cadangan_umum}}% @endif</td>
                </tr>
                <tr style="text-align: center">
                    <td style="text-align: left">&nbsp;&nbsp;- Cadangan Tujuan</td>
                    <td align="right">@if(is_null($last)) - @else  @currency($last->cadangan_tujuan) @endif</td>
                    <td align="right">@currency($now->cadangan_tujuan)</td>
                    <td>@currency($p_cadangan_tujuan)</td>
                    <td>@if(is_null($last)) - @else {{$p_persen_cadangan_tujuan}}% @endif</td>
                </tr>
                <tr style="text-align: center">
                    <td style="text-align: left">&nbsp;&nbsp;- Laba/Rugi tahun Berjalan</td>
                    <td align="right">@if(is_null($last)) - @else  @currency($last->laba_rugi_thnberjalan) @endif</td>
                    <td align="right">@currency($now->laba_rugi_thnberjalan)</td>
                    <td>@currency($p_laba_rugi_thnberjalan)</td>
                    <td>@if(is_null($last)) - @else {{$p_persen_laba_rugi_thnberjalan}}% @endif</td>
                </tr>
                <tr style="text-align: center">
                    <td style="text-align: left">&nbsp;&nbsp;- Laba/Rugi tahun Lalu</td>
                    <td align="right">@if(is_null($last)) - @else  @currency($last->laba_rugi_thnlalu) @endif</td>
                    <td align="right">@currency($now->laba_rugi_thnlalu)</td>
                    <td>@currency($p_laba_rugi_thnlalu)</td>
                    <td>@if(is_null($last)) - @else {{$p_persen_laba_rugi_thnlalu}}% @endif</td>
                </tr>
                <tr style="text-align: center">
                    <td style="text-align: left">&nbsp;&nbsp;- Modal Pelengkap ATMR</td>
                    <td align="right">@if(is_null($last)) - @else  @currency($last->modal_pelengkap) @endif</td>
                    <td align="right">@currency($now->modal_pelengkap)</td>
                    <td>@currency($p_modal_pelengkap)</td>
                    <td>@if(is_null($last)) - @else {{$p_persen_modal_pelengkap}}% @endif</td>
                </tr>
                <tr style="text-align: center">
                    <td style="text-align: left">&nbsp;&nbsp;- Godwill</td>
                    <td align="right">@if(is_null($last)) - @else  @currency($last->godwill) @endif</td>
                    <td align="right">@currency($now->godwill)</td>
                    <td>@currency($p_godwill)</td>
                    <td>@if(is_null($last)) - @else {{$p_persen_godwill}}% @endif</td>
                </tr>
                <tr style="font-weight: bold; text-align: center">
                    <td style="text-align: left">CAR</td>
                    <td align="right">@if(is_null($last)) - @else {{$last->CAR}}% @endif</td>
                    <td align="right">{{$now->CAR}}%</td>
                    <td style="background-color:rgb(0, 0, 0)""></td>
                    <td>@if(is_null($last)) - @else {{$p_persen_car}}% @endif</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection