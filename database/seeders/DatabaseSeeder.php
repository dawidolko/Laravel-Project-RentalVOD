<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\MoviesSeeder;
use Database\Seeders\UsersSeeder;
use Database\Seeders\LoansSeeder;
use Database\Seeders\OpinionsSeeder;
use Database\Seeders\LoansMoviesSeeder;
use Database\Seeders\CategoriesSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategoriesSeeder::class,
            MoviesSeeder::class,
            RoleSeeder::class,
            UsersSeeder::class,
            LoansSeeder::class,
            LoansMoviesSeeder::class,
            OpinionsSeeder::class,
        ]);
    }
}
