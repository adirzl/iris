<?php

namespace Modules\HCS\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JabatanImport implements ToCollection, WithHeadingRow
{
    use Importable;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $collect) {
            \Illuminate\Support\Facades\DB::table('hcs_jabatan')->insert([
                'kode' => $collect['kode'],
                'nama' => $collect['nama'],
                'status' => $collect['status'],
            ]);
        }
    }
}
