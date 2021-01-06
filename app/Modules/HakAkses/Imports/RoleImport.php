<?php

namespace Modules\HakAkses\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RoleImport implements ToCollection, WithHeadingRow
{
    use Importable;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $now = now();

        foreach ($collection as $collect) {
            \Illuminate\Support\Facades\DB::table('mst_role')->insert([
                'id' => $collect['id'],
                'name' => to_upper($collect['name']),
                'guard_name' => 'web',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
