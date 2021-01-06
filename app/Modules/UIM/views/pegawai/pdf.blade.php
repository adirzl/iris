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
                            {{-- <th>Induk</th> --}}
                            <th>Unit Kerja</th>
                            <th>Jabatan</th>
                            <th>Penempatan</th>
                            <th>Grade</th>
                            <th>Admin SPV TI</th>
                            <th>Hak Akses</th>
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
                            {{-- <td>{{ isset($d->unitKerjaInduk->nama_cabang) ? $d->unitKerjaInduk->nama_cabang : '-' }}</td> --}}
                            <td>{{ isset($d->unitKerja->nama_cabang) ? $d->unitKerja->nama_cabang : '-' }}</td>
                            <td>{{ $d->nama_jabatan }}</td>
                            <td>{{ $d->nama_penempatan }}</td>
                            <td>{{ $d->nama_grade }}</td>
                            <td>{{ $d->admin_spv_ti }}</td>
                            <td>{{ $d->hakakses }}</td>
                            <td>{{ $d->status_karyawan }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>