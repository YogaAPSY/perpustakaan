<?php

use App\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return Book::create([
            'name' => 'J.K Rowling',
            'author_id' => 1,
            'image' => 'noimage.jpg',
            'description' => 'Lorem ipsum dolor sit amet',
            'year' => '1994',
        ]);
    }
}
