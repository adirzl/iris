@extends('layouts.app_landing')
@section('content')

<!-- Page Title ============================================= -->
<section id="page-title">

    <div class="container clearfix">
        <h1>Laporan Pengisian Kuisioner Manajemen Risiko</h1>
    </div>

</section>
<!-- #page-title end -->

<!-- Content ============================================= -->
<section id="content">
    <div class="content-wrap">
        <div class="container">

            <div class="row gutter-40 col-mb-80">
                <div class="postcontent col-lg-9">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>
                                        <center>No</center>
                                    </th>
                                    <th>
                                        <center>Nama LJK</center>
                                    </th>
                                    <th>
                                        <center>Periode</center>
                                    </th>
                                    <th>
                                        <center>Tanggal Penigisian</center>
                                    </th>
                                    <th>
                                        <center>File</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $d)    
                                <tr>
                                    <td align="center">{{$i++}}</td>
                                    <td align="left">{{ $d->get_company_name->company_name }}</td>
                                    <td align="left">{{ $d->periode !== '-' ? $periode[$d->periode] : $d->periode }} - {{ substr($d->created_at,0,4) }}</td>
                                    <td align="center">{{ $d->created_at }}</td>
                                    <td align="center">
                                        <a href="{{ url('report_kuisioner_manrisk/export/'.$d->id.'?type=xls') }}" class="btn btn-success export-file">
                                            <i class="icon-file-excel"></i>&nbsp;Excel
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- #content end -->

@endsection