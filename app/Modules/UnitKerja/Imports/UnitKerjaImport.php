<?php

namespace Modules\UnitKerja\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\UnitKerja\Entities\UnitKerja;

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
                'kode_induk' => $collect['kode_induk'],
                'kode_kanwil' => $collect['kode_kanwil'],
                'nama_kanwil' => $collect['nama_kanwil'],
                'status' => $collect['status'],
                'created_at' => $now,
                'updated_at' => $now
            ]);

        }
    }
}
