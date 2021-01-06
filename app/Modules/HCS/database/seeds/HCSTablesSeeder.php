<?php

namespace Modules\HCS\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HCSTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hcs_grade')->delete();
        (new \Modules\HCS\Imports\GradeImport)->import('imports/HCS/Grade.xlsx');
        
        DB::table('hcs_jabatan')->delete();
        (new \Modules\HCS\Imports\JabatanImport)->import('imports/HCS/StrukturOrganisasi.xlsx');
        
        DB::table('hcs_unit_kerja')->delete();
        (new \Modules\HCS\Imports\UnitKerjaImport)->import('imports/HCS/UnitKerja.xlsx');
        
        DB::table('hcs_pegawai')->delete();
        (new \Modules\HCS\Imports\PegawaiImport)->import('imports/HCS/Pegawai.xlsx');
    }
}
