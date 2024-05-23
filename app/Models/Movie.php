<?php

namespace App\Models;

use App\Services\MovieService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    public $timestamps = false;
    protected $table = 'movies';

    protected $fillable = [
        'id', 'title', 'description', 'category_id', 'director', 'release_year', 'duration', 'rate', 'img_path', 'video_path', 'price_day', 'old_price', 'super_promo_price', 'last_promo_update', 'available'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function opinions()
    {
        return $this->hasMany(Opinion::class, 'movie_id');
    }

    public function loans()
    {
        return $this->belongsToMany(Loan::class, 'loan_movie', 'movie_id', 'loan_id');
    }

}
