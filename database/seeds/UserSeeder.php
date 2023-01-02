<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            // 'name' => 'Super Admin',
            'username' => 'administrator',
            'password' => bcrypt('rahasia123'),
            // 'email' => 'studentxprogrammer@gmail.com',
            // 'role' => '1',
        ]);
    }
}
