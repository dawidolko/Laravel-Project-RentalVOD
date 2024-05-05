<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Category::insert([
        // DB::table('categories')->insert([
            ['species' => 'Akcja'],
            ['species' => 'Komedia'],
            ['species' => 'Dramat'],
            ['species' => 'Fantasy'],
            ['species' => 'Horror'],
            ['species' => 'Romans'],
            ['species' => 'Przygodowy'],
            ['species' => 'Thriller'],
            ['species' => 'Naukowa-fikcja'],
            ['species' => 'Dokumentalny'],
            ['species' => 'Animacja'],
            ['species' => 'Biograficzny'],
            ['species' => 'Historyczny'],
            ['species' => 'Muzyczny'],
            ['species' => 'Wojenny'],
            ['species' => 'Western'],
            ['species' => 'Sportowy'],
            ['species' => 'Kryminał'],
            ['species' => 'Mystery'],
            ['species' => 'Rodzinny']
        ]);
    }
}
