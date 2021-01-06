<?php

use Illuminate\Database\Seeder;

class RsmUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new \Modules\User\Imports\RsmUserImport)->import('imports/User.xlsx');
    }
}
