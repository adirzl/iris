@extends('layouts.app')
@section('title', 'Kolek Persektor')
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
                    <th style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Jenis Kredit</th>
                    <th style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Outstanding</th>
                    <th style="width:200px; color: white; background-color:rgb(0, 0, 0)"">Proporsi</th>
                </tr>
                <tr style=" text-align: center">
                    <td>Produktif</td>
                    <td>@currency($datas->produktif)</td>
                    <td>{{ number_format((float)$p_produktif, 2, '.', '') }}%</td>
                </tr>
                <tr style=" text-align: center">
                    <td>Konsumtif</td>
                    <td>@currency($datas->konsumtif)</td>
                    <td>{{ number_format((float)$p_konsumtif, 2, '.', '') }}%</td>
                </tr>
                <tr style=" text-align: center; color: white; background-color:rgb(0, 0, 0)""">
                    <td>Jumlah</td>
                    <td>@currency($jumlah)</td>
                    <td></td>
                </tr>
            </table><br>
        </div>
    </div>
</div> 
@endsection