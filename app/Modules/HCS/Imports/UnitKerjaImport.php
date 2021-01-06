<?php

namespace Modules\HCS\Imports;

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
            \Illuminate\Support\Facades\DB::table('hcs_unit_kerja')->insert([
                'kode' => $collect['kode'],
                'treecode' => $collect['treecode'],
                'parentcode' => $collect['parentcode'],
                'nama' => $collect['nama'],
                'alamat' => $collect['alamat'],
                'kota' => $collect['kota'],
                'status' => $collect['status'],
            ]);
        }
    }
}
