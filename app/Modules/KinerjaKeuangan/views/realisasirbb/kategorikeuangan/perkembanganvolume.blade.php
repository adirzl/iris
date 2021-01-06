@extends('layouts.app')
@section('title', 'Perkembangan Volume Usaha')
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
                    <th rowspan="2" style="width:350px; color: white; background-color:rgb(0, 0, 0)"">Indikator</th>
                    <th rowspan="2" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">{{$bulan[$datas->bulan]}} - {{$datas->tahun-1}}</th>
                    <th rowspan=" 2" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">{{$bulan[$datas->bulan]}} - {{$datas->tahun}}</th>
                    <th rowspan=" 2" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Target <br>{{$bulan[$datas->bulan]}} {{$datas->tahun}}</th>
                    <th colspan=" 2" style="width:300px; color: white; background-color:rgb(0, 0, 0)"">Pertumbuhan YoY</th>
                    <th rowspan=" 2" style="width:180px; color: white; background-color:rgb(0, 0, 0)"">Pencapaian RBB</th>
                </tr>
                <tr style=" text-align: center">
                    <th style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Rp</th>
                    <th style=" width:200px; color: white; background-color:rgb(0, 0, 0)"">%</th>
                </tr>
                <tr style="font-weight: bold; text-align: center">
                    <td style="text-align: left">Total Aset</td>
                    <td align="right">@if(is_null($last)) - @else @currency($last->total_aset) @endif</td>
                    <td align="right">@currency($datas->total_aset)</td>
                    <td align="right">@if(is_null($target)) - @else @currency($target->total_aset * 1000000) @endif</td>
                    @if($p_aset < 0) <td align="right">(@currency($p_aset))</td>
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
                    <td align="right">@currency($datas->total_aba)</td>
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
                    <td align="right">@currency($datas->total_kredit)</td>
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
                    <td align="right">@currency($datas->dana_pihaktiga)</td>
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
                    <td align="right">@currency($datas->pinjaman_diterima)</td>
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
                    <td align="right">@currency($datas->modal)</td>
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
                    <td align="right">@currency($datas->laba_rugi)</td>
                    <td align="right">@if(is_null($target)) - @else @currency($target->laba_rugi * 1000000) @endif</td>
                    @if($p_laba_rugi < 0) <td align="right">(@currency($p_laba_rugi))</td>
                    @else
                    <td align="right">@currency($p_laba_rugi)</td>
                    @endif
                    <td>{{$p_persen_laba_rugi}}%</td>
                    <td>{{$p_laba_rugi_penc}}%</td>
                </tr>
            </table><br>
            <!-- chart -->

            <div class="col-xs-6">
                <figure class="highcharts-figure">
                    <br>
                    <div id="container"></div><br><hr><br>
                    <div id="container2"></div>
                </figure>
            </div>

            <script type="text/javascript">
                var jArray = <?php echo json_encode($periode_bulan); ?>;
                var totAset = <?php echo json_encode($tot_aset); ?>;
                var totAba = <?php echo json_encode($tot_aba); ?>;
                var totKredit = <?php echo json_encode($tot_kredit); ?>;
                var totDanaPihakKetiga = <?php echo json_encode($dana_pihak_ketiga); ?>;
                var totSimpananBankLain = <?php echo json_encode($simpanan_bank_lain); ?>;
                var totPinjamanDiterima = <?php echo json_encode($pinjaman_diterima); ?>;
                var totLabaRugi = <?php echo json_encode($laba_rugi); ?>;
                Highcharts.chart('container', {
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: 'Aktiva'
                    },
                    subtitle: {
                        text: 'Perkembangan Volume Usaha'
                    },
                    xAxis: {
                        categories: jArray
                    },
                    yAxis: {
                        title: {
                            text: 'Pencapaian Dlm Ribuan Rp, kecuali %'
                        }
                    },
                    plotOptions: {
                        line: {
                            dataLabels: {
                                enabled: true
                            },
                            enableMouseTracking: false
                        }
                    },
                    series: [{
                        name: 'Total Aset',
                        data: totAset
                    }, {
                        name: 'Total ABA',
                        data: totAba
                    }, {
                        name: 'Total Kredit',
                        data: totKredit
                    }]
                });

                Highcharts.chart('container2', {
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: 'Pasiva'
                    },
                    subtitle: {
                        text: 'Perkembangan Volume Usaha'
                    },
                    xAxis: {
                        categories: jArray
                    },
                    yAxis: {
                        title: {
                            text: 'Pencapaian Dlm Ribuan Rp, kecuali %'
                        }
                    },
                    plotOptions: {
                        line: {
                            dataLabels: {
                                enabled: true
                            },
                            enableMouseTracking: false
                        }
                    },
                    series: [{
                        name: 'Dana Pihak Ketiga',
                        data: totDanaPihakKetiga
                    }, {
                        name: 'Simpanan Bank Lain',
                        data: totSimpananBankLain
                    }, {
                        name: 'Pinjaman Yang Diterima',
                        data: totPinjamanDiterima
                    }, {
                        name: 'Laba/Rugi',
                        data: totLabaRugi
                    }]
                });
            </script>

            <!-- endchart -->

        </div>
    </div>
</div>

@endsection