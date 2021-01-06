<?php

namespace Modules\UIM\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UIMTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('uim_unit_kerja')->delete();
        (new \Modules\UIM\Imports\UnitKerjaImport)->import('imports/UIM/UnitKerja.xlsx');
        
        DB::table('uim_pegawai')->delete();
        (new \Modules\UIM\Imports\PegawaiImport)->import('imports/UIM/Pegawai.xlsx');
        
        DB::table('uim_ubah_limit')->delete();
        (new \Modules\UIM\Imports\UbahLimitImport)->import('imports/UIM/UbahLimit.xlsx');
    }
}
