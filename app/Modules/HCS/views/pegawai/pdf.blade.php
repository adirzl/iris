<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include('components.html.raw-css')
        <title>Pegawai (HCS)</title>
    </head>
    <body>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>User ID</th>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>Email</th>
                            <th>HP</th>
                            <th>Unit Kerja</th>
                            <th>Penempatan</th>
                            <th>Jabatan</th>
                            <th>Grade</th>
                            <th>Status</th>
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
                            <td>{{ isset($d->unitKerja->nama) ? $d->unitKerja->nama : '-' }}</td>
                            <td>{{ isset($d->penempatan->nama) ? $d->penempatan->nama : '-' }}</td>
                            <td>{{ isset($d->jabatan->nama) ? $d->jabatan->nama : '-' }}</td>
                            <td>{{ isset($d->grade->nama) ? $d->grade->nama : '-' }}</td>
                            <td>{{ $d->status_karyawan }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>