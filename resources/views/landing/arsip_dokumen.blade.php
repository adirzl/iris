@extends('layouts.app_landing')
@section('content')
    <section id="page-title">
        <div class="container clearfix">
            {{-- <h1>{{ strtoupper($unitkerja->name) }}</h1> --}}
            <h1>Arsip Dokumen</h1>
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
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th>Nomor</th>
                                            <th>Nama Dokumen</th>
                                            <th>Kategori</th>
                                            <th>Type</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
                                <button class="btn btn-secondary">Cari</button>
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
