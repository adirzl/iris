<table>
    <tr style="text-align: center">
        <th style="width:350px">Indikator</th>
        <th style="width:300px">{{$bulan[$now->bulan]}} - {{$now->tahun - 1}}</th>
        <th style="width:300px">{{$bulan[$now->bulan]}} - {{$now->tahun}}</th>
    </tr>
    <tr>
        <td style="text-align: left">Rasio LCR</td>
        <td align="center">@if(is_null($lastyear)) - @else {{$lastyear->rasio_lcr}}% @endif</td>
        <td align="center">{{$now->rasio_lcr}}%</td>
    </tr>
</table>