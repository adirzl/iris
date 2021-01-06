<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include('components.html.raw-css')
        <title>Registrasi Aplikasi</title>
    </head>
    <body>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>ID Aplikasi</th>
                            <th>Nama</th>
                            <th>Keterangan</th>
                            <th>Alamat</th>
                            <th>Ada Limit Aplikasi</th>
                            <th>Akses</th>
                            <th>Muncul di UIM</th>
                            <th>Otentikasi User</th>
                            <th>Sinkronisasi</th>
                            <th>Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $d->idaplikasi }}</td>
                            <td>{{ $d->nama }}</td>
                            <td>{{ $d->keterangan }}</td>
                            <td>{{ $d->alamat }}</td>
                            <td>{{ $char_decision[$d->ada_limit] }}</td>
                            <td>{{ $d->akses !== '-' ? $akses_aplikasi[$d->akses] : $d->akses }}</td>
                            <td>{{ $char_decision[$d->muncul_di_uim] }}</td>
                            <td>{{ !is_null($d->otentikasi_user) ? $otentikasi_user[$d->otentikasi_user] : '-' }}</td>
                            <td>{{ $bool_decision[$d->sinkronisasi] }}</td>
                            <td>{{ \Carbon\Carbon::parse($d->created_at)->eq($d->update_at) ? format_date($d->created_at, '%d/%m/%Y %H:%M:%S') : format_date($d->updated_at, '%d/%m/%Y %H:%M:%S') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>