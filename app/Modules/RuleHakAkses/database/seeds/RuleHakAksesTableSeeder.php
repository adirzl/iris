<?php

namespace Modules\RuleHakAkses\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RuleHakAksesTableSeeder extends Seeder
{
    /**
     * @var string
     */
    protected $table = 'app_hak_akses';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table($this->table)->delete();
        $now = now();
        $rows = [
            [
                'id' => Str::uuid(), 'grade' => '["0138","0127","0122","0125","0126","0133","0091","0092","0093","0094","0095","0096","0097","0098","0099","0100","0101","0182"]',
                'pegawai_ti' => 'f', 'as_admin_spv' => 'f', 'as_admin' => 'f', 'primary_level' => 3, 'secondary_level' => 1,
                'sequence' => 1, 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'id' => Str::uuid(), 'grade' => null,
                'pegawai_ti' => 'f', 'as_admin_spv' => 'f', 'as_admin' => 'f', 'primary_level' => 2, 'secondary_level' => null,
                'sequence' => 2, 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'id' => Str::uuid(), 'grade' => '["0138","0133","0087","0088","0089","0090","0091","0092","0093","0094","0095","0096","0097","0098","0100"]',
                'pegawai_ti' => 't', 'as_admin_spv' => 'f', 'as_admin' => 'f', 'primary_level' => 3, 'secondary_level' => 1,
                'sequence' => 3, 'created_at' => $now, 'updated_at' => $now
            ],
        ];

        foreach ($rows as $row) {
            DB::table($this->table)->insert($row);
        }
    }
}
