@extends('layouts.app')
@section('title', 'Rasio Keuangan')
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
                    <th rowspan="2" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Rasio</th>
                    <th rowspan="2" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">{{$bulan[$now->bulan]}} - {{$now->tahun-1}}</th>
                    <th rowspan="2" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">{{$bulan[$now->bulan]}} - {{$now->tahun}}</th>
                    <th colspan="1" style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Pertumbuhan</th>
                    <th rowspan="2" style="width:300px; color: white; background-color:rgb(0, 0, 0)"">Kriteria Rasio per {{$bulan[$now->bulan]}} - {{$now->tahun}}</th>
                </tr>
                <tr style=" text-align: center">
                    <th colspan="1"style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Yoy</th>
                </tr>
                <tr style=" text-align: center">
                    <td>CAR</td>
                    <td>@if(is_null($last)) - @else {{$last->car}}% @endif</td>
                    <td>{{$now->car}}%</td>
                    <td>{{$p_car}}%</td>
                    <td>{{ $now->car >= 12 ? 'Sehat' : 'Tidak Sehat' }}</td>
                </tr>
                <tr style=" text-align: center">
                    <td>NPL</td>
                    <td>@if(is_null($last)) - @else {{$last->npl}}% @endif</td>
                    <td>{{$now->npl}}%</td>
                    <td>{{$p_npl}}%</td>
                    <td>{{ $now->npl >= 5 ? 'Tidak Wajar' : 'Sehat' }}</td>
                </tr>
                <tr style=" text-align: center">
                    <td>CR</td>
                    <td>@if(is_null($last)) - @else {{$last->cr}}% @endif</td>
                    <td>{{$now->cr}}%</td>
                    <td>{{$p_cr}}%</td>
                    <td>@if (round((float)$now->cr >= 4,05)) Sehat @elseif (round((float)$now->cr >= 3,30) && round((float)$now->cr < 4,05)) Cukup Sehat @elseif (round((float)$now->cr >= 2,55) && round((float)$now->cr <= 3,30)) Kurang Sehat @elseif (round((float)$now->cr < 2,55)) Tidak Sehat @endif</td>
                </tr>
                <tr style=" text-align: center">
                    <td>LDR</td>
                    <td>@if(is_null($last)) - @else {{$last->ldr}}% @endif</td>
                    <td>{{$now->ldr}}%</td>
                    <td>{{$p_ldr}}%</td>
                    <td>@if (round((float)$now->ldr <= 94,75)) Sehat @elseif (round((float)$now->ldr > 94,75) && round((float)$now->ldr <= 98,50)) Cukup Sehat @elseif (round((float)$now->ldr > 98,50) && round((float)$now->ldr <= 102,25)) Kurang Sehat @elseif (round((float)$now->ldr > 102,25)) Tidak Sehat @endif</td>
                </tr>
                <tr style=" text-align: center">
                    <td>ROA</td>
                    <td>@if(is_null($last)) - @else {{$last->roa}}% @endif</td>
                    <td>{{$now->roa}}%</td>
                    <td>{{$p_roa}}%</td>
                    <td>@if (round((float)$now->roa >= 1,21)) Sehat @elseif (round((float)$now->roa >= 0,99) && round((float)$now->roa < 1,21)) Cukup Sehat @elseif (round((float)$now->roa >= 0,76) && round((float)$now->roa < 0,99)) Kurang Sehat @elseif (round((float)$now->roa < 0,76)) Tidak Sehat @endif</td>
                </tr>
                <tr style=" text-align: center">
                    <td>BOPO</td>
                    <td>@if(is_null($last)) - @else {{$last->bopo}}% @endif</td>
                    <td>{{$now->bopo}}%</td>
                    <td>{{$p_bopo}}%</td>
                    <td>@if (round((float)$now->bopo <= 93,52)) Sehat @elseif (round((float)$now->bopo > 93,52) && round((float)$now->bopo <= 94,72)) Cukup Sehat @elseif (round((float)$now->bopo > 94,72) && round((float)$now->bopo <= 95,92)) Kurang Sehat @elseif (round((float)$now->bopo > 95,92)) Tidak Sehat @endif</td>
                </tr>
            </table><br>
        </div>
    </div>
</div> 
@endsection