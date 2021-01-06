<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Kode</th>
            <th>Nama</th>
            <th>Nama Induk</th>
            <th>Kanwil</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($data as $d)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $d->kode_cabang }}</td>
                <td>{{ $d->nama_cabang }}</td>
                <td>{{ $d->nama_induk }}</td>
                <td>{{ $d->nama_kanwil }}</td>
                <td>{{ $d->status }}</td>
            </tr>
    @endforeach
    </tbody>
</table>