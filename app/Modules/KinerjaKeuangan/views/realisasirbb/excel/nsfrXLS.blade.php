<table>
    <tr style="text-align: center">
        <th style="width:350px">Indikator</th>
        <th style="width:300px">{{$bulan[$now->bulan]}} - {{$now->tahun - 1}}</th>
        <th style="width:300px">{{$bulan[$now->bulan]}} - {{$now->tahun}}</th>
    </tr>
    <tr>
        <td style="text-align: left">Rasio NSFR</td>
        <td align="center">@if(is_null($lastyear)) - @else {{$lastyear->rasio_nsfr}}% @endif</td>
        <td align="center">{{$now->rasio_nsfr}}%</td>
    </tr>
</table>