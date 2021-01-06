<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Aplikasi</th>
            <th>ID Fungsi</th>
            <th>Fungsi</th>
            <th>Menu</th>
            <th>Fungsi Akses 1</th>
            <th>Fungsi Akses 2</th>
            <th>SPV</th>
            <th>Limit Debit</th>
            <th>Limit Kredit</th>
            <th>Status</th>
            <th>Sinkronisasi</th>
            <th>Timestamp</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($data as $d)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $d->aplikasi->idaplikasi }} - {{ $d->aplikasi->nama }}</td>
            <td>{{ $d->idfungsi }}</td>
            <td>{{ $d->nama }}</td>
            <td>{{ $d->menu }}</td>
            <td>{{ akses_aplikasi($d->akses1) }}</td>
            <td>{{ akses_aplikasi($d->akses2) }}</td>
            <td>{{ $char_decision[$d->spv] }}</td>
            <td>{{ number_format($d->limit_debit) }}</td>
            <td>{{ number_format($d->limit_kredit) }}</td>
            <td>{{ $status[$d->status] }}</td>
            <td>{{ $bool_decision[$d->sinkronisasi] }}</td>
            <td>{{ \Carbon\Carbon::parse($d->created_at)->eq($d->update_at) ? format_date($d->created_at, '%d/%m/%Y %H:%M:%S') : format_date($d->updated_at, '%d/%m/%Y %H:%M:%S') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>