@extends('layouts.app_landing')
@section('content')

    @if ($unitkerja)
        <section id="page-title">
            <div class="container clearfix">
                <h1>{{ strtoupper($unitkerja->nama) }}</h1>
                <span>Deskripsi singkat judul</span>
            </div>
        </section>
        <section id="content">
            <div class="content-wrap">
                <div class="container clearfix">

                    <section id="content">
                        <div class="content-wrap">
                            <div class="container clearfix">
                                <div class="row">
                                    <div class="postcontent col-lg-9">
                                        <ul>
                                            <div class="table-responsive">
                                                {{ Form::hidden('unitkerja_kode', $unitkerja->kode, ['id' => 'unitkerja_kode']) }}
                                                <table class="table table-bordered table-striped mb-0" id="table-file">
                                                    <thead>
                                                        <tr>
                                                            <th>Actions</th>
                                                            <th>Nama Dokumen</th>
                                                            <th>Type</th>
                                                            <th>Tanggal</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($fileArchive as $item)
                                                            <tr>
                                                                <td>
                                                                    @if ($item->tipe_dokumen == 2 || isset($item->last_requestfile->first()->status) == 2)
                                                                        <a href="{{ asset('storage/dokumen/' . $item->unitkerja_kode . '/' . $item->filetype_id . '/' . $item->filename) }}"
                                                                            class="btn btn-success" target="_blank">Open</a>
                                                                    @else
                                                                        @if (Auth::check())
                                                                            <a href="{{ route('landingrequestfile', ['id' => $item->id]) }}"
                                                                                class="btn btn-warning">Request</a>
                                                                        @else
                                                                            <input type="hidden" name="filearchive" id="filearchive"
                                                                                value="{{ $item->id }}">
                                                                            <button data-toggle="modal" class="btn btn-warning"
                                                                                data-target=".bs-example-modal-lg"
                                                                                id="request">Request</button>
                                                                        @endif
                                                                    @endif
                                                                </td>
                                                                <td>{{ $item->label }}</td>
                                                                <td>{{ $item->file_type->name }}</td>
                                                                <td>{{ $item->created_at }}</td>
                                                                <td>
                                                                    <span class="badge bg-success"
                                                                        style="color: white">{{ $tipe_dokumen[$item->tipe_dokumen] }}</span>&nbsp;
                                                                    <span class="badge bg-info"
                                                                        style="color: white">{{ $item->fileext }}</span>
                                                                    @if ($item->tipe_dokumen == 1)
                                                                        <span class="badge bg-danger"
                                                                            style="color: white">{{ isset($status_requestfile[isset($item->last_requestfile->first()->status)]) ? isset($status_requestfile[isset($item->last_requestfile->first()->status)]) : '' }}</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
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
                                                <div style="margin-top: 10%">
                                                    <label>File Type</label>
                                                    @foreach ($fileType as $item)
                                                        <li>{{ Form::checkbox('fileType_id[]', $item->id, null, ['class' => 'f_filetype']) }}
                                                            {{ $item->name }}</li>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </section>


                </div>
            </div>
        </section>
    @endif
@endsection
