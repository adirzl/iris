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
<<<<<<< HEAD
=======
        $this->call(UnitKerjaSeeder::class);
>>>>>>> 93d9db87bd277d61cf8c1b1259765c955673085d
        $this->call(UsersTableSeeder::class);


    }
}
