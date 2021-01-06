<table>
    <tr style="text-align: center">
        <th style="width:200px">Jenis Kredit</th>
        <th style="width:200px">Outstanding</th>
        <th style="width:200px">Proporsi</th>
    </tr>
    <tr style="text-align: center">
        <td>Produktif</td>
        <td>@currency($now->produktif)</td>
        <td>{{ number_format((float)$p_produktif, 2, '.', '') }}%</td>
    </tr>
    <tr style="text-align: center">
        <td>Konsumtif</td>
        <td>@currency($now->konsumtif)</td>
        <td>{{ number_format((float)$p_konsumtif, 2, '.', '') }}%</td>
    </tr>
    <tr style="text-align: center">
        <td>Jumlah</td>
        <td>@currency($jumlah)</td>
        <td></td>
    </tr>
</table><br>