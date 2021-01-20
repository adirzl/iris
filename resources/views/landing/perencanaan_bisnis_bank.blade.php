@extends('layouts.app_landing')
@section('content')
    <section id="page-title">
        <div class="container clearfix">
            {{-- <h1>{{ strtoupper($unitkerja->name) }}</h1> --}}
            <h1>Perencanaan Bisnis Bank</h1>
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
                                <table class="table table-bordered table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>Actions</th>
                                            <th>Nomor</th>
                                            <th>Nama Dokumen</th>
                                            <th>Kategori</th>
                                            <th>Type</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
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
                                <button class="btn btn-primary">Cari</button>
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
