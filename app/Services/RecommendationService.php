<?php

namespace App\Services;

use Hoa\Ruler\Ruler;
use Hoa\Ruler\Context;
use App\Models\Movie;
use Illuminate\Support\Facades\Cache;

class RecommendationService
{
    protected $ruler;

    public function __construct()
    {
        $this->ruler = new Ruler();
    }

    public function getTopRecommendedMovies()
    {
        $rule = $this->getRule();
        $movies = Movie::withCount('recommendations')->get();
        $recommendedMovies = [];

        foreach ($movies as $movie) {
            $context = new Context();
            $context['movie'] = $movie->toArray();

            if ($this->ruler->assert($rule, $context)) {
                $recommendedMovies[] = $movie;
            }
        }

        usort($recommendedMovies, function ($a, $b) {
            return $b->recommendations_count <=> $a->recommendations_count;
        });

        return array_slice($recommendedMovies, 0, 5);
    }

    public function setRule($rate, $recommendationsCount)
    {
        $rule = 'movie["rate"] > ' . $rate . ' and movie["recommendations_count"] > ' . $recommendationsCount;
        Cache::put('recommendation_rule', $rule);
    }

    public function getRule()
    {
        return Cache::get('recommendation_rule', 'movie["rate"] > 4 and movie["recommendations_count"] > 0');
    }

    public function parseRule($rule)
    {
        preg_match('/movie\["rate"\] > (\d+(\.\d+)?) and movie\["recommendations_count"\] > (\d+)/', $rule, $matches);
        return [$matches[1], $matches[3]];
    }
}
