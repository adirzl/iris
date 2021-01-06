<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Kode</th>
            <th>Nama</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($data as $d)
            <tr>
                <td>{{ $d->iteration }}</td>
                <td>{{ $d->kode }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $status[$d->status] }}</td>
            </tr>
    @endforeach
    </tbody>
</table>