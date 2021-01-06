<?php

namespace Modules\UIM\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UnitKerjaImport implements ToCollection, WithHeadingRow
{
    use Importable;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $collect) {
            if (!is_null($collect['kodecabang']) && $collect['status'] !== 'NULL' && !is_null($collect['status'])) {
                \Illuminate\Support\Facades\DB::table('uim_unit_kerja')->insert([
                    'kode_cabang' => trim($collect['kodecabang']),
                    'nama_cabang' => trim($collect['namacabang']),
                    'kode_induk' => trim($collect['kodeinduk']),
                    'nama_induk' => trim($collect['namainduk']),
                    'kode_kanwil' => ($collect['kodekanwil'] === 'NULL' ? null : trim($collect['kodekanwil'])),
                    'nama_kanwil' => ($collect['namakanwil'] === 'NULL' ? null : trim($collect['namakanwil'])),
                    'kode_hc' => ($collect['kodecabang_hris'] === 'NULL' ? null : trim($collect['kodecabang_hris'])),
                    'alamat' => ($collect['alamat1'] === 'NULL' ? null : trim($collect['alamat1'])),
                    'kota' => ($collect['kota'] === 'NULL' ? null : trim($collect['kota'])),
                    'status' => trim($collect['status']),
                ]);
            }
        }
    }
}
