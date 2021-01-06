@extends('layouts.app')
@section('title', 'NSFR')
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
                    <th style="width:350px; color: white; background-color:rgb(0, 0, 0)"">Indikator</th>
                    <th style="width:300px; color: white; background-color:rgb(0, 0, 0)"">{{$bulan[$datas->bulan]}} - {{$datas->tahun - 1}}</th>
                    <th style="width:300px; color: white; background-color:rgb(0, 0, 0)"">{{$bulan[$datas->bulan]}} - {{$datas->tahun}}</th>
                </tr>
                <tr>
                    <td style="text-align: left">Rasio NSFR</td>
                    <td align="center">@if(is_null($lastyear)) - @else {{$lastyear->rasio_nsfr}}% @endif</td>
                    <td align="center">{{$datas->rasio_nsfr}}%</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection