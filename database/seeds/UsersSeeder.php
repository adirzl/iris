<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('app_user')->delete();
        (new \Modules\User\Imports\UserImport)->import('imports/User.xlsx');
    }
}
