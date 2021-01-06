<?php

namespace App\Imports;

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
        $now = now();

        foreach ($collection as $collect) {
            \Illuminate\Support\Facades\DB::table('app_unit_kerja')->insert([
                'kode' => $collect['kode'],
                'nama' => $collect['nama'],
                'parentkode' => $collect['parentkode'],
                'kodeuim' => $collect['kodeuim'],
                'cabang' => $collect['cabang'],
                'kanwil' => $collect['kanwil'],
            ]);
        }
    }
}
