<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>User ID</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Aplikasi</th>
            <th>Kode Cabang</th>
            <th>Limit Oto Kredit</th>
            <th>Limit Oto Debit</th>
            <th>Grup Limit</th>
            <th>Limit Oto Kredit Default</th>
            <th>Limit Oto Debit Default</th>
            <th>Tgl. Sinkronisasi</th>
            <th>Sinkronisasi</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($data as $d)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $d->userid }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->jabatan->jabatan }}</td>
                <td>{{ $d->aplikasi }}</td>
                <td>{{ $d->kode_cabang }}</td>
                <td>{{ $d->limit_oto_kredit }}</td>
                <td>{{ $d->limit_oto_debit }}</td>
                <td>{{ $d->grup_limit }}</td>
                <td>{{ $d->limit_oto_kredit_default }}</td>
                <td>{{ $d->limit_oto_debit_default }}</td>
                <td>{{ format_date($d->tgl_sinkronisasi, '%d/%m/%Y') }}</td>
                <td>{{ $bool_decision[$d->sinkronisasi] }}</td>
            </tr>
    @endforeach
    </tbody>
</table>