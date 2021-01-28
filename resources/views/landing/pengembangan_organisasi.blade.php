@extends('layouts.app_landing')
@section('content')
    <section id="page-title">
        <div class="container clearfix">
            {{-- <h1>{{ strtoupper($unitkerja->name) }}</h1> --}}
            <h1>Pengembangan Organisasi</h1>
            <span>Deskripsi singkat judul</span>
        </div>
    </section>
    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                <div class="row">
                    <div class="postcontent col-lg-9">
                        <ul>
                            {{-- @foreach ($data as $item)
                                <li>{{ $item->name }}</li>
                            @endforeach --}}
                            <div class="table-responsive">
<<<<<<< HEAD
                                <table class="table table-bordered mb-0">
                                    <thead style="text-align: center">
                                        <tr>
=======
                                <table class="table table-bordered table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>Actions</th>
>>>>>>> 93d9db87bd277d61cf8c1b1259765c955673085d
                                            <th>Nomor</th>
                                            <th>Nama Dokumen</th>
                                            <th>Kategori</th>
                                            <th>Type</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
<<<<<<< HEAD
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody style="text-align: center">
                                        <tr>
                                            <td>1</td>
                                            <td>$nama_dokumen</td>
                                            <td>$kategori</td>
                                            <td>$type</td>
                                            <td>$tanggal</td>
                                            <td>$status</td>
                                            <td>$action</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>$nama_dokumen</td>
                                            <td>$kategori</td>
                                            <td>$type</td>
                                            <td>$tanggal</td>
                                            <td>$status</td>
                                            <td>$action</td>
=======
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info">Actions</button>
                                                    <button type="button"
                                                        class="btn btn-info dropdown-toggle dropdown-toggle-split"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#">View</a>
                                                        <a class="dropdown-item" href="#">Download</a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>1</td>
                                            <td>Kajian stabilitas keuangan</td>
                                            <td>docx</td>
                                            <td>no 32 November 2020</td>
                                            <td>20-01-2021</td>
                                            <td><span class="badge bg-success" style="color: white">Public</span></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info">Actions</button>
                                                    <button type="button"
                                                        class="btn btn-info dropdown-toggle dropdown-toggle-split"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#">Request</a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>2</td>
                                            <td>RBB Bank bjb 2021</td>
                                            <td>pdf</td>
                                            <td>no 12 Desember 2020</td>
                                            <td>20-01-2021</td>
                                            <td><span class="badge bg-warning">Private</span></td>
>>>>>>> 93d9db87bd277d61cf8c1b1259765c955673085d
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </ul>
                    </div>

                    <div class="sidebar col-lg-3">
                        <div class="sidebar-widgets-wrap">
                            <div class="widget clearfix">
                                {{ Form::text('keyword', null, ['class' => 'form-control', 'id' => 'keyword', 'placeholder' => 'Pencarian']) }}
                                <br>
<<<<<<< HEAD
                                <button class="btn btn-secondary">Cari</button>
=======
                                <button class="btn btn-primary">Cari</button>
>>>>>>> 93d9db87bd277d61cf8c1b1259765c955673085d
                                <div style="margin-top: 10%">
                                    <label>File Type</label>
                                    <li>{{ Form::checkbox('fileType[]', true, null) }} [name]</li>
                                    {{-- @foreach ($fileType as $item)
                                        <ul>
                                            <li>{{ Form::checkbox('fileType[]', true, null) }} {{ $item->name }}</li>
                                        </ul>
                                    @endforeach --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
