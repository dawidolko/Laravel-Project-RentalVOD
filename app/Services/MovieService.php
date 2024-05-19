<?php

namespace App\Services;

use App\Models\Movie;
use App\Models\Loan;
use App\Models\PremiumMovie;

class MovieService
{
    public function calculateDynamicPrice(Movie $movie)
    {
        // Liczba wypożyczeń danego filmu
        $loansCount = Loan::whereHas('movies', function ($query) use ($movie) {
            $query->where('movie_id', $movie->id);
        })->count();

        // Liczba zakupów wersji premium danego filmu
        $premiumCount = PremiumMovie::where('movie_id', $movie->id)->count();

        // Progi popularności
        $highPopularityThreshold = 20;
        $mediumPopularityThreshold = 10;

        // Bazowa cena filmu
        $basePrice = $movie->price_day;

        // Dynamiczna zmiana ceny w zależności od popularności
        if ($loansCount + $premiumCount >= $highPopularityThreshold) {
            return $basePrice * 1.5; // Podwyżka o 50%
        } elseif ($loansCount + $premiumCount >= $mediumPopularityThreshold) {
            return $basePrice * 1.25; // Podwyżka o 25%
        } else {
            return $basePrice * 0.75; // Obniżka o 25%
        }
    }
}
