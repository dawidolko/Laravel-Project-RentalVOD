<?php

namespace App\Services;

use App\Models\Movie;
use App\Models\Loan;
use App\Models\PremiumMovie;
use Carbon\Carbon;

class MovieService
{
    public function calculateDynamicPrice(Movie $movie)
    {
        $loansCount = Loan::whereHas('movies', function ($query) use ($movie) {
            $query->where('movie_id', $movie->id);
        })->count();

        $premiumCount = PremiumMovie::where('movie_id', $movie->id)->count();

        $highPopularityThreshold = 20;
        $mediumPopularityThreshold = 10;

        $basePrice = $movie->old_price; // Używamy old_price jako bazowej ceny

        if ($loansCount + $premiumCount >= $highPopularityThreshold) {
            return round($basePrice * 1.5, 2);
        } elseif ($loansCount + $premiumCount >= $mediumPopularityThreshold) {
            return round($basePrice * 1.25, 2);
        } else {
            return round($basePrice * 0.75, 2);
        }
    }

    public function getPriceWithSuperPromotion(Movie $movie)
    {
        return $movie->super_promo_price ?? $this->calculateDynamicPrice($movie);
    }

    public function calculatePromoPrice($price)
    {
        if ($price < 9) {
            return $price;
        } elseif ($price < 15) {
            return $price - 2;
        } else {
            return $price - 5;
        }
    }

    public function updatePrices()
    {
        $movies = Movie::all();

        foreach ($movies as $movie) {
            if ($this->shouldUpdatePrice($movie)) {
                if ($movie->super_promo_price === null) {
                    $dynamicPrice = $this->calculateDynamicPrice($movie);
                    $movie->old_price = $movie->price_day;
                    $movie->price_day = $dynamicPrice;
                    $movie->last_promo_update = Carbon::now();
                    $movie->save();
                }
            }
        }
    }

    public function shouldUpdatePrice(Movie $movie)
    {
        $lastUpdate = Carbon::parse($movie->last_promo_update);
        return $lastUpdate->diffInSeconds(Carbon::now()) >= 10; // Aktualizacja co 10 sekund
    }
}
