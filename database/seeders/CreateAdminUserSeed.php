<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateAdminUserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
           'firstname' => 'admin',
           'lastname' => 'admin',
           'phone' => '11111111' ,
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'status' => 1,
        ]);
    }
}
