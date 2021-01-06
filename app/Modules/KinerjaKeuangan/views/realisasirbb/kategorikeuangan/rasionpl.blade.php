@extends('layouts.app')
@section('title', 'Rasio NPL')
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
                    <th rowspan="3" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Indikator</th>
                    <th rowspan="2" colspan="3" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Periode</th>
                    <th colspan="4" style="width:300px; color: white; background-color:rgb(0, 0, 0)"">Pertumbuhan</th>
                </tr>
                <tr style=" text-align: center">
                    {{-- <th colspan="3" style="width:200px; background-color:goldenrod""></th> --}}
                    <th colspan="2" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Monthly</th>
                    <th colspan="2"style="width:200px; color: white; background-color:rgb(0, 0, 0)"">YoY</th>
                </tr>
                <tr style=" text-align: center">
                    <th style="width:200px; color: white; background-color:rgb(0, 0, 0)"">{{$bulan[$datas->bulan]}} - {{$datas->tahun - 1}}</th>
                    <th style="width:200px; color: white; background-color:rgb(0, 0, 0)"">@if($datas->bulan == 1) {{$bulan[$datas->bulan]}} - {{$datas->tahun}} @else {{$bulan[$datas->bulan - 1]}} - {{$datas->tahun}} @endif</th>
                    <th style="width:200px; color: white; background-color:rgb(0, 0, 0)"">{{$bulan[$datas->bulan]}} - {{$datas->tahun}}</th>
                    <th style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Rp</th>
                    <th style="width:200px; color: white; background-color:rgb(0, 0, 0)"">%</th>
                    <th style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Rp</th>
                    <th style="width:200px; color: white; background-color:rgb(0, 0, 0)"">%</th>
                </tr>
                <tr style=" text-align: center">
                    <td style="text-align: left">Lancar</td>
                    <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->lancar) @endif</td>
                    <td align="right">@if(is_null($lastmonth)) - @else @currency($lastmonth->lancar) @endif</td>
                    <td align="right">@currency($datas->lancar)</td>
                    <td align="right">@currency($p_lancar_month)</td>
                    <td>{{ number_format((float)$p_persen_lancarmonth, 2, '.', '') }}%</td>
                    <td align="right">@currency($p_lancar_year)</td>
                    <td>{{ number_format((float)$p_persen_lancaryear, 2, '.', '') }}%</td>
                </tr>
                <tr style="text-align: center">
                    <td style="text-align: left">Dalam Perhatian Khusus</td>
                    <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->dalam_perhatian) @endif</td>
                    <td align="right">@if(is_null($lastmonth)) - @else @currency($lastmonth->dalam_perhatian) @endif</td>
                    <td align="right">@currency($datas->dalam_perhatian)</td>
                    <td align="right">@currency($p_dalamperhatian_month)</td>
                    <td align="right"></td>
                    <td align="right">@currency($p_dalamperhatian_year)</td>
                    <td></td>
                </tr>
                <tr style="text-align: center">
                    <td style="text-align: left">Kurang Lancar</td>
                    <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->kurang_lancar) @endif</td>
                    <td align="right">@if(is_null($lastmonth)) - @else @currency($lastmonth->kurang_lancar) @endif</td>
                    <td align="right">@currency($datas->kurang_lancar)</td>
                    <td align="right">@currency($p_kuranglancar_month)</td>
                    <td>{{ number_format((float)$p_persen_kuranglancarmonth, 2, '.', '') }}%</td>
                    <td align="right">@currency($p_kuranglancar_year)</td>
                    <td>{{ number_format((float)$p_persen_kuranglancaryear, 2, '.', '') }}%</td>
                </tr>
                <tr style="text-align: center">
                    <td style="text-align: left">Diragukan</td>
                    <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->diragukan) @endif</td>
                    <td align="right">@if(is_null($lastmonth)) - @else @currency($lastmonth->diragukan) @endif</td>
                    <td align="right">@currency($datas->diragukan)</td>
                    <td align="right">@currency($p_diragukan_month)</td>
                    <td>{{ number_format((float)$p_persen_diragukanmonth, 2, '.', '') }}%</td>
                    <td align="right">@currency($p_diragukan_year)</td>
                    <td>{{ number_format((float)$p_persen_diragukanyear, 2, '.', '') }}%</td>
                </tr>
                <tr style="text-align: center">
                    <td style="text-align: left">Macet</td>
                    <td align="right">@if(is_null($lastyear)) - @else @currency($lastyear->macet) @endif</td>
                    <td align="right">@if(is_null($lastmonth)) - @else @currency($lastmonth->macet) @endif</td>
                    <td align="right">@currency($datas->macet)</td>
                    <td align="right">@currency($p_macet_month)</td>
                    <td>{{ number_format((float)$p_persen_macetmonth, 2, '.', '') }}%</td>
                    <td align="right">@currency($p_macet_year)</td>
                    <td>{{ number_format((float)$p_persen_macetyear, 2, '.', '') }}%</td>
                </tr>
                <tr style="font-weight: bold; text-align: center; background-color:rgb(214, 230, 250)"">
                    <td>Total</td>
                    <td align="right">@currency($totalastyear)</td>
                    <td align="right">@currency($totalastmonth)</td>
                    <td align="right">@currency($total)</td>
                    <td align="right">@currency($total_pertumbuhan_month)</td></td>
                    <td>{{ number_format((float)$p_persen_totalmonth, 2, '.', '') }}%</td>
                    <td align="right">@currency($total_pertumbuhan_year)</td></td>
                    <td>{{ number_format((float)$p_persen_totalyear, 2, '.', '') }}%</td>
                </tr>
                <tr style="text-align: center; color: white; background-color:rgb(0, 0, 0)"">
                    <td>Total Kredit Non Lancar</td>
                    <td align="right">@currency($totalnonlancar_lastyear)</td>
                    <td align="right">@currency($totalnonlancar_lastmonth)</td>
                    <td align="right">@currency($totalnonlancar)</td>
                    <td align="right">@currency($total_nonlancarmonth)</td>
                    <td align="right"></td>
                    <td align="right">@currency($total_nonlancaryear)</td>
                    <td></td>
                </tr>
                <tr style="text-align: center; color: white; background-color:rgb(0, 0, 0)"">
                    <td>Rasio NPL Gross</td>
                    <td align="right">@if(is_null($lastyear)) - @else {{$lastyear->rasio_npl_gross}}% @endif</td>
                    <td align="right">@if(is_null($lastmonth)) - @else {{$lastmonth->rasio_npl_gross}}% @endif</td>
                    <td align="right">{{$datas->rasio_npl_gross}}%</td>
                    <td align="right"></td>
                    <td align="right"></td>
                    <td align="right"></td>
                    <td></td>
                </tr>
            </table>

            {{-- <script type="text/javascript">
                var jArray = <?php echo json_encode($periode_bulan); ?>;
                var totNpl = <?php echo json_encode($total_npl); ?>;
                Highcharts.chart('container', { 
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: 'Proyeksi'
                    },
                    subtitle: {
                        text: 'Rasio NPL'
                    },
                    xAxis: {
                        categories: jArray
                    },
                    yAxis: {
                        title: {
                            text: 'Pencapaian Dlm %'
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
                        name: 'Total NPL',
                        data: totAset
                    }]
                });
            </script> --}}

        </div>
    </div>
</div> 
@endsection