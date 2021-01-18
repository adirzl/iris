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
        $this->call(UnitKerjaSeeder::class);
        $this->call(ConfigurationTableSeeder::class);
        $this->call(Modules\Opsi\Database\Seeds\OptionsTablesSeeder::class);
        $this->call(PermissionsTablesSeeder::class);
        // $this->call(UnitKerjaSeeder::class);
        $this->call(UsersTableSeeder::class);


    }
}
