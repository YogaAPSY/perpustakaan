<?php

use App\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return Author::create([
            'name' => 'J.K Rowling',
        ]);
    }
}
