@extends('layouts.app_landing')
@section('content')

<!-- Page Title ============================================= -->
<section id="page-title">

    <div class="container clearfix">
        <h1>Report Penginputan Sumber Data</h1>
    </div>

</section>
<!-- #page-title end -->

<section id="content">
    <div class="content-wrap">
        <div class="container clearfix">
            <div class="row gutter-40 col-mb-80">
                <div class="postcontent col-lg-9">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th><center>No</center></th>
                                    <th><center>Nama LJK</center></th>
                                    <th><center>LBU/LKAP</center></th>
                                    <th><center>NERACA</center></th>
                                    <th><center>LABA RUGI</center></th>
                                    <th><center>NOMINATIF DPK</center></th>
                                    <th><center>NOMINATIF KREDIT</center></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td align="center">1</td>
                                    <td align="center">Bank bjb Syariah</td>
                                    <td align="center"><span class="i-bordered i-circled mx-auto icon-ok"></span></td>
                                    <td align="center"><span class="i-bordered i-circled mx-auto icon-ok"></span></td>
                                    <td align="center"><span class="i-bordered i-circled mx-auto icon-ok"></span></td>
                                    <td align="center"><span class="i-bordered i-circled mx-auto icon-remove"></span></td>
                                    <td align="center"><span class="i-bordered i-circled mx-auto icon-remove"></span></td>
                                </tr>
                                <tr>
                                    <td align="center">2</td>
                                    <td align="center">Bank Karya Utama</td>
                                    <td align="center"><span class="i-bordered i-circled mx-auto icon-ok"></span></td>
                                    <td align="center"><span class="i-bordered i-circled mx-auto icon-remove"></span></td>
                                    <td align="center"><span class="i-bordered i-circled mx-auto icon-ok"></span></td>
                                    <td align="center"><span class="i-bordered i-circled mx-auto icon-ok"></span></td>
                                    <td align="center"><span class="i-bordered i-circled mx-auto icon-ok"></span></td>
                                </tr>
                                <tr>
                                    <td align="center">3</td>
                                    <td align="center"> Bank Intan Jabar</td>
                                    <td align="center"><span class="i-bordered i-circled mx-auto icon-ok"></span></td>
                                    <td align="center"><span class="i-bordered i-circled mx-auto icon-remove"></span></td>
                                    <td align="center"><span class="i-bordered i-circled mx-auto icon-ok"></span></td>
                                    <td align="center"><span class="i-bordered i-circled mx-auto icon-remove"></span></td>
                                    <td align="center"><span class="i-bordered i-circled mx-auto icon-ok"></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection