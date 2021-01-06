@extends('layouts.app_landing')
@section('content')

<!-- Page Title ============================================= -->
<section id="page-title">

    <div class="container clearfix">
        <h1>Laporan Pengisian Kuisioner Audit Internal</h1>
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
                                        <center>Status</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td align="center">1</td>
                                    <td align="center">Bank bjb Syariah</td>
                                    <td align="center">TW II - 2020</td>
                                    <td align="center">
                                        <ul class="process-steps process-5 row col-mb-30 justify-content-center mb-4">
                                            <li class="col-sm-6 col-lg-1-5 active">
                                                <a href="#" class="i-bordered i-circled mx-auto icon-line-paper-stack"></a>
                                                <h5>Belum Isi</h5>
                                            </li>
                                            <li class="col-sm-6 col-lg-1-5">
                                                <a href="#" class="i-bordered i-circled mx-auto icon-line-paper"></a>
                                                <h5>Draft</h5>
                                            </li>
                                            <li class="col-sm-6 col-lg-1-5">
                                                <a href="#" class="i-bordered i-circled mx-auto icon-line-check"></a>
                                                <h5>Sudah Isi</h5>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">1</td>
                                    <td align="center">Bank Karya Utama</td>
                                    <td align="center">TW II - 2020</td>
                                    <td align="center">
                                        <ul class="process-steps process-5 row col-mb-30 justify-content-center mb-4">
                                            <li class="col-sm-6 col-lg-1-5">
                                                <a href="#" class="i-bordered i-circled mx-auto icon-line-paper-stack"></a>
                                                <h5>Belum Isi</h5>
                                            </li>
                                            <li class="col-sm-6 col-lg-1-5 active">
                                                <a href="#" class="i-bordered i-circled mx-auto icon-line-paper"></a>
                                                <h5>Draft</h5>
                                            </li>
                                            <li class="col-sm-6 col-lg-1-5">
                                                <a href="#" class="i-bordered i-circled mx-auto icon-line-check"></a>
                                                <h5>Sudah Isi</h5>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">1</td>
                                    <td align="center">Bank Intan Jabar</td>
                                    <td align="center">TW II - 2020</td>
                                    <td align="center">
                                        <ul class="process-steps process-5 row col-mb-30 justify-content-center mb-4">
                                            <li class="col-sm-6 col-lg-1-5">
                                                <a href="#" class="i-bordered i-circled mx-auto icon-line-paper-stack"></a>
                                                <h5>Belum Isi</h5>
                                            </li>
                                            <li class="col-sm-6 col-lg-1-5">
                                                <a href="#" class="i-bordered i-circled mx-auto icon-line-paper"></a>
                                                <h5>Draft</h5>
                                            </li>
                                            <li class="col-sm-6 col-lg-1-5 active">
                                                <a href="#" class="i-bordered i-circled mx-auto icon-line-check"></a>
                                                <h5>Sudah Isi</h5>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
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