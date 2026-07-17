<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Panggil seeder hasil generate iseed
        $this->call([
            BooksTableSeeder::class,
            PartsTableSeeder::class,
            ChaptersTableSeeder::class,
            FormsTableSeeder::class,
        ]);
        $this->call(BooksTableSeeder::class);
        $this->call(PartsTableSeeder::class);
        $this->call(ChaptersTableSeeder::class);
        $this->call(FormsTableSeeder::class);
    }
}
