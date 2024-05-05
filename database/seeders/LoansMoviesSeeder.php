<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Movies;

class LoansMoviesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $loanMovies = [
            [
                'loan_id' => 1,
                'movie_id' => 1, 
            ],
            [
                'loan_id' => 2,
                'movie_id' => 2,        
            ],
            [
                'loan_id' => 3,
                'movie_id' => 3,       
            ],
            [
                'loan_id' => 4,
                'movie_id' => 4,          
            ],
            [
                'loan_id' => 5,
                'movie_id' => 5, 
            ],
            [
                'loan_id' => 6,
                'movie_id' => 6,
            ],
            [
                'loan_id' => 7,
                'movie_id' => 7,
            ],
            [
                'loan_id' => 8,
                'movie_id' => 8,
            ],
            [
                'loan_id' => 9,
                'movie_id' => 9,
            ],
            [
                'loan_id' => 10,
                'movie_id' => 10,
            ],
        ];

        // Wstawianie danych do tabeli
        foreach ($loanMovies as $loanMovie) {
            // DB::table('loan_movie')->insert([
                Movies::insert([
                'loan_id' => $loanMovie['loan_id'],
                'movie_id' => $loanMovie['movie_id'],    ]);
        }
    }
}
