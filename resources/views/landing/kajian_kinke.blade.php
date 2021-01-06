@extends('layouts.app_landing')
@section('content')

<!-- Page Title ============================================= -->
<section id="page-title">

    <div class="container clearfix">
        <h1>Tentang Kajian Kinerja Keuangan</h1>
    </div>

</section>
<!-- #page-title end -->

<!-- Content ============================================= -->
<section id="content">
    <div class="content-wrap">
        <div class="container clearfix">

            <!-- <div class="col-12 form-group">
                <div class="row">
                    <div class="col-md-3 form-group">
                        <label>Periode</label>
                        <select class="form-control required" name="jobs-application-type" id="jobs-application-type">
                            <option value="">-- Pilih Salah Satu --</option>
                            <option value="Juli">Juli</option>
                            <option value="Juni">Juni</option>
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Tahun</label>
                        <select class="form-control required" name="jobs-application-type" id="jobs-application-type">
                            <option value="">-- Pilih Salah Satu --</option>
                            <option value="Juli">2020</option>
                            <option value="Juni">2019</option>
                        </select>
                    </div>

                    <div class="postcontent col-lg-9">
                        <button class="button button-rounded button-reveal button-large button-white button-light text-right"><i class="icon-search2"></i><span>Cari</span></button>
                    </div>
                </div>
            </div> -->

            <div class="table-responsive">
                <table id="datatable1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Nama Perusahaan</th>
                            <th>Judul Laporan</th>
                            <th>Periode</th>
                            <th>Tahun</th>
                            <th>File</th>
                            {{-- <th>Status</th> --}}
                            <th>Keterangan</th>
                            <th style="width: 10%">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $v)
                        <tr>
                            <td>{{ $v->get_company_name->company_name }}</td>
                            <td>{{ $v->title }}</td>
                            <td>{{ $v->periode !== '-' ? $bulan[$v->periode] : $v->periode }}</td>
                            <td>{{ $v->tahun }}</td>
                            <td><a href="{{ asset('laporan_files/' . $v->file) }}">{{ $v->file }}</a></td>
                            {{-- <td><span class="badge badge-{{ $v->status_progres == 3 ? 'success' : 'warning'}}">{{ $v->status_progres !== '-' ? $status_progres[$v->status_progres] : $v->status_progres }}</span></td> --}}
                            <td>{{ $v->description }}</td>
                            <td>{{ $v->created_at->toDateString() }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</section>
<!-- #content end -->
@endsection