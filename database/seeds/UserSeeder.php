<?php

use App\User;
use Carbon\Carbon;
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
        $user = [
            [
                'name' => 'admin perpustakaan',
                'email' => 'admin@admin.com',
                'role' => 'admin',
                'status' => 1,

                'password' => bcrypt('password'),
                'created_at' => Carbon::now()
            ], [
                'name' => 'user perpustakaan',
                'email' => 'user@gmail.com',
                'role' => 'user',
                'status' => 1,

                'password' => bcrypt('password'),
                'created_at' => Carbon::now()
            ]
        ];
        return User::insert($user);
    }
}
