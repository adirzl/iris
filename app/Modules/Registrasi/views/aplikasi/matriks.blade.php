<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include('components.html.raw-css')
        <title>Matriks {{ $registrasi_aplikasi->nama }}</title>
    </head>
    <body>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID Aplikasi</th>
                            <th>Nama Aplikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $registrasi_aplikasi->idaplikasi }}</td>
                            <td>{{ $registrasi_aplikasi->nama }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID Fungsi</th>
                            <th>Nama</th>
                            <th>Akses 1</th>
                            <th>Akses 2</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($registrasi_aplikasi->fungsi->sortBy('idfungsi') as $d)
                        <tr>
                            <td>{{ $d->idfungsi }}</td>
                            <td>{{ $d->nama }}</td>
                            <td>{{ akses_aplikasi($d->akses1) }}</td>
                            <td>{{ akses_aplikasi($d->akses2) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>