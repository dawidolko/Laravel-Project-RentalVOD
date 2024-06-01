<?php

namespace App\Services;

use App\Models\Movie;
use App\Models\Loan;
use App\Models\PremiumMovie;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class MovieService
{
    protected $promotionsEnabled;

    public function __construct()
    {
        $this->promotionsEnabled = Cache::get('promotions_enabled', true);
    }

    public function calculateDynamicPrice(Movie $movie)
    {
        $loansCount = Loan::whereHas('movies', function ($query) use ($movie) {
            $query->where('movie_id', $movie->id);
        })->count();

        $premiumCount = PremiumMovie::where('movie_id', $movie->id)->count();

        $highPopularityThreshold = 20;
        $mediumPopularityThreshold = 10;

        $basePrice = $movie->old_price;

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
        if ($price > 15) {
            return $price;
        } elseif ($price <= 15 && $price > 13) {
            return $price - 2.43;
        } elseif ($price <= 13 && $price > 11) {
            return $price - 3.79;
        } elseif ($price <= 11 && $price > 9) {
            return $price - 2.67;
        } elseif ($price <= 9) {
            return $price - 1.43;
        } else {
            return $price - 0.99;
        }
    }

    public function updatePrices()
    {
        if (!$this->promotionsEnabled) {
            return;
        }

        $movies = Movie::all();

        foreach ($movies as $movie) {
            if ($this->shouldUpdatePrice($movie)) {
                if ($movie->super_promo_price === null) {
                    $dynamicPrice = $this->calculateDynamicPrice($movie);
                    $promoPrice = $this->calculatePromoPrice($dynamicPrice);
                    $movie->old_price = $movie->price_day;
                    $movie->price_day = $promoPrice;
                    $movie->last_promo_update = Carbon::now();
                    $movie->save();
                }
            }
        }
    }

    public function shouldUpdatePrice(Movie $movie)
    {
        $lastUpdate = Carbon::parse($movie->last_promo_update);
        return $lastUpdate->diffInSeconds(Carbon::now()) >= 10;
    }

    public function arePromotionsEnabled()
    {
        return $this->promotionsEnabled;
    }

    public function togglePromotions()
    {
        $this->promotionsEnabled = !$this->promotionsEnabled;
        Cache::put('promotions_enabled', $this->promotionsEnabled);
    }
}
