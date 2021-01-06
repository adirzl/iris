<?php

namespace Modules\LimitOtorisasi\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class LimitOtorisasiTableSeeder extends Seeder
{
    /**
     * @var string
     */
    protected $table = 'app_limit_oto';

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
                'id' => Str::uuid(), 'kode' => 'PCAB', 'jabatan' => '["J0825"]', 
                'limit_kredit' => 150000000000, 'limit_debit' => 150000000000,
                'created_at' => $now, 'updated_at' => $now
            ],
            [
                'id' => Str::uuid(), 'kode' => 'MANCAB', 'jabatan' => '["J0826"]', 
                'limit_kredit' => 25000000000, 'limit_debit' => 25000000000,
                'created_at' => $now, 'updated_at' => $now
            ],
            [
                'id' => Str::uuid(), 'kode' => 'PINKCP', 'jabatan' => '["J0849"]', 
                'limit_kredit' => 10000000000, 'limit_debit' => 10000000000,
                'created_at' => $now, 'updated_at' => $now
            ],
            [
                'id' => Str::uuid(), 'kode' => 'SPVCAB', 'jabatan' => '["J0860","J0831"]', 
                'limit_kredit' => 5000000000, 'limit_debit' => 5000000000,
                'created_at' => $now, 'updated_at' => $now
            ],
            [
                'id' => Str::uuid(), 'kode' => 'SPVKCP', 'jabatan' => '["J0914"]', 
                'limit_kredit' => 5000000000, 'limit_debit' => 5000000000,
                'created_at' => $now, 'updated_at' => $now
            ],
        ];

        foreach ($rows as $row) {
            DB::table($this->table)->insert($row);
        }
    }
}
