<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include('components.html.raw-css')
        <title>Unit Kerja (HCS)</title>
    </head>
    <body>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode</th>
                            <th>Tree Code</th>
                            <th>Nama</th>
                            <th>Parent Code</th>
                            <th>Alamat</th>
                            <th>Kota</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $d->kode }}</td>
                            <td>{{ $d->treecode }}</td>
                            <td>{{ $d->nama }}</td>
                            <td>{{ $d->parentcode }}</td>
                            <td>{{ $d->alamat }}</td>
                            <td>{{ $d->kota }}</td>
                            <td>{{ $status[$d->status] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>