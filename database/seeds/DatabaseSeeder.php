<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ConfigurationTableSeeder::class);
        $this->call(Modules\Opsi\Database\Seeds\OptionsTablesSeeder::class);
        $this->call(PermissionsTablesSeeder::class);
        $this->call(Modules\RuleHakAkses\Database\Seeds\RuleHakAksesTableSeeder::class);
        $this->call(Modules\LimitOtorisasi\Database\Seeds\LimitOtorisasiTableSeeder::class);
        $this->call(Modules\API\Database\Seeds\DatasourceTableSeeder::class);
        // $this->call(RsmUsersSeeder::class);
    }
}
