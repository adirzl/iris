<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>IP Address</th>
            <th>Nama</th>
            <th>Hash Key</th>
            <th>Server Environment</th>
            <th>Blacklist</th>
            <th>Koneksi UIM API</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($data as $d)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $d->ip_address }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->hash_key }}</td>
                <td>{{ $environment[$d->environment] }}</td>
                <td>{{ $bool_decision[$d->blacklist] }}</td>
                <td>{{ $environment[$d->koneksi] }}</td>
            </tr>
    @endforeach
    </tbody>
</table>