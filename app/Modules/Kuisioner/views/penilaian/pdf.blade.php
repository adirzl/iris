<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include('components.html.raw-css')
        <title>Kuisioner </title>
    </head>
    <body>
        <div class="row">
            <div class="col-md-12">
            @if($kuisioner->status_kuisioner == 1)
                @foreach ($data_pertanyaan as $data)
                
                <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                    
                        <tr>
                            <th colspan="5" style="text-align: center"><strong><h2>KERTAS KERJA PEMANTAUAN FUNGSI KEPATUHAN</h2></strong></th>
                        </tr>
                        
                        <tr>
                            <th colspan="5" style="text-align: center"><strong><h2>PADA PERUSAHAAN ANAK DAN PERUSAHAN TERELASI</h2></strong></th>
                        </tr>
                        <tr>
                            <td colspan="5"></td>
                        </tr>

                        <tr>
                            <th colspan="1"><strong><h2>Periode</h2></strong></th>
                            <th colspan="4"><strong><h2>{{$kuisioner->periode}}</h2></strong></th>
                        </tr>
                        
                        <tr>
                            <th colspan="1"><strong><h2>Nama Anak Perusahaan</h2></strong></th>
                            <th colspan="4"><strong><h2>{{$kuisioner->nama_perusahaan}}</h2></strong></th>
                        </tr>
                        
                        <tr>
                            <th colspan="1"><strong><h2>Modal Inti</h2></strong></th>
                            <th colspan="4"><strong><h2>{{$kuisioner->modal_inti}}</h2></strong></th>
                        </tr>
                        
                        <tr>
                            <th colspan="1"><strong><h2>Nama Pengisi Kuisioner</h2></strong></th>
                            <th colspan="4"><strong><h2>{{$kuisioner->user}}</h2></strong></th>
                        </tr>
                        <tr>
                            <td colspan="5"></td>
                        </tr>

                        <tr>
                            <th colspan="1"><h4><strong>Pertanyaan</strong></h4></th>
                            <th colspan="4"><h4><strong>{{ $data->description }}</strong></h4></th>
                        </tr>

                        <tr>
                            <th><strong>No</strong></th>
                            <th style="width: 30%;"><strong>Pertanyaan Kuisioner</strong></th>
                            <th><strong>Penilaian</strong></th>
                            <th><strong>Bukti Implementasi</strong></th>
                            <th><strong>Keterangan</strong></th>
                        </tr>

                        @foreach ($data->detail_pertanyaan->where('id_induk',$data->id) as $vd)
                        <tr>
                            <td>{{ $vd->no_pertanyaan }}</td>
                            <td>{{ $vd->pertanyaan }}</td>
                            @foreach($data_penilaian->where('id_pertanyaan_detail', $vd->id) as $v2)
                            <td>{{ $v2->jawaban !== '-' ? $jawaban[$v2->jawaban] : $v2->jawaban }}</td>
                            <td>{{ $v2->file }}</td>
                            <td>{{ $v2->description }}</td>
                        </tr>
                        @endforeach
                        @endforeach
                </table>
                @endforeach
            @else
                @foreach ($data_pertanyaan as $data)

                <table>
                        <tr>
                            <th colspan="4" style="text-align: center"><strong><h2>KERTAS KERJA PEMANTAUAN FUNGSI KEPATUHAN</h2></strong></th>
                        </tr>
                        
                        <tr>
                            <th colspan="4" style="text-align: center"><strong><h2>PADA PERUSAHAAN ANAK DAN PERUSAHAN TERELASI</h2></strong></th>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                        </tr>

                        <tr>
                            <th colspan="1"><strong><h2>Periode</h2></strong></th>
                            <th colspan="3"><strong><h2>{{$kuisioner->periode}}</h2></strong></th>
                        </tr>
                        
                        <tr>
                            <th colspan="1"><strong><h2>Nama Anak Perusahaan</h2></strong></th>
                            <th colspan="3"><strong><h2>{{$kuisioner->nama_perusahaan}}</h2></strong></th>
                        </tr>
                        
                        <tr>
                            <th colspan="1"><strong><h2>Modal Inti</h2></strong></th>
                            <th colspan="3"><strong><h2>{{$kuisioner->modal_inti}}</h2></strong></th>
                        </tr>
                        
                        <tr>
                            <th colspan="1"><strong><h2>Nama Pengisi Kuisioner</h2></strong></th>
                            <th colspan="3"><strong><h2>{{$kuisioner->user}}</h2></strong></th>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                        </tr>

                        <tr>
                            <th colspan="1"><h4><strong>Pertanyaan</strong></h4></th>
                            <th colspan="3"><h4><strong>{{ $data->description }}</strong></h4></th>
                        </tr>
                    
                        <tr>
                            <th style="text-align: center"><strong>No</strong></th>
                            <th style="text-align: center"><strong>Jawaban</strong></th>
                            <th style="text-align: center">
                                <strong>Tandai Salah Satu</strong>
                            </th>
                            <th style="text-align: center"><strong>Keterangan</strong></th>
                        </tr>
                        <tr>
                            <th style="text-align: center"><strong>A</strong></th>
                            <th style="text-align: center"><strong>B</strong></th>
                            <th style="text-align: center"><strong>C</strong></th>
                            <th style="text-align: center"><strong>D</strong></th>
                        </tr>

                
                        @foreach ($data->detail_pertanyaan->where('id_induk',$data->id) as $vd)
                        <tr>
                            <td style="text-align: center">{{ $vd->no_pertanyaan }}</td>
                            <td>{{ $vd->pertanyaan }}</td>
                            <td style="text-align: center">
                                @foreach($data_penilaian->where('id_pertanyaan_detail', $vd->id) as $v2)
                                {{ $v2->jawaban == 1 ? 'X' : '' }}
                            </td>
                            <td>{{ $v2->description }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    
                </table>
                @endforeach
            @endif
            </div>
        </div>
    </body>
</html>