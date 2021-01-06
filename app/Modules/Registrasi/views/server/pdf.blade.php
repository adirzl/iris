<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include('components.html.raw-css')
        <title>Registrasi Server</title>
    </head>
    <body>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
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
                            <td>{{ $loop->ip_iteration }}</td>
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
            </div>
        </div>
    </body>
</html>