<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>User ID</th>
            <th>Nama</th>
            <th>NIP</th>
            <th>Email</th>
            <th>HP</th>
            <th>Nama Induk</th>
            <th>Nama Cabang</th>
            <th>Nama Jabatan</th>
            <th>Nama Penempatan HCS</th>
            <th>Grade</th>
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
                <td>{{ $d->nip }}</td>
                <td>{{ $d->email }}</td>
                <td>{{ $d->hp }}</td>
                <td>{{ $d->nama_induk }}</td>
                <td>{{ $d->nama_cabang }}</td>
                <td>{{ $d->nama_jabatan }}</td>
                <td>{{ $d->nama_penempatan }}</td>
                <td>{{ $d->nama_grade }}</td>
                <td>{{ format_date($d->tgl_sinkronisasi, '%d/%m/%Y') }}</td>
                <td>{{ $bool_decision[$d->sinkronisasi] }}</td>
            </tr>
    @endforeach
    </tbody>
</table>