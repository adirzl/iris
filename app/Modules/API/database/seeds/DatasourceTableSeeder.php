<?php

namespace Modules\API\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DatasourceTableSeeder extends Seeder
{
    /**
     * @var string
     */
    protected $table = 'api_datasource';

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
                'id' => Str::uuid(), 'nama' => 'HCS', 'environment' => 'production', 
                'dialect' => 'pgsql', 'properties' => '{"driver":"PostgreSQL","server":"10.6.231.80","port":"5432","database":"hcsolutions","username":"postgres","password":"postgres"}',
                'status' => 't', 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'id' => Str::uuid(), 'nama' => 'UIM', 'environment' => 'production', 
                'dialect' => 'mssql', 'properties' => '{"driver":"FreeTDS","server":"10.6.225.225","port":"1433","database":"uim","username":"sa","password":"sa"}',
                'status' => 't', 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'id' => Str::uuid(), 'nama' => 'UIM_API_DEV', 'environment' => 'development', 
                'dialect' => 'mssql', 'properties' => '{"driver":"SQL Server","server":"10.6.226.199","port":"1433","database":"uim_api","username":"sa","password":"SQL4dm1n"}',
                'status' => 't', 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'id' => Str::uuid(), 'nama' => 'UIM_API_PROD', 'environment' => 'production', 
                'dialect' => 'mssql', 'properties' => '{"driver":"SQL Server","server":"10.6.231.125","port":"1433","database":"uim-api_v1","username":"sa","password":"SQL4dm1n"}',
                'status' => 't', 'created_at' => $now, 'updated_at' => $now
            ],
        ];

        foreach ($rows as $row) {
            DB::table($this->table)->insert($row);
        }
    }
}
