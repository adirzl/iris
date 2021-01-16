<?php

use Illuminate\Database\Seeder;

class UnitKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('app_unit_kerja')->delete();
        (new \Modules\UnitKerja\Imports\UnitKerjaImport)->import('imports/UnitKerja.xlsx');
    }
}
