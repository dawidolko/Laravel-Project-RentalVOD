<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    public $timestamps = false;
    protected $table = 'movies'; // Nazwa tabeli w bazie danych

    protected $fillable = [
        'id', 'title', 'description', 'category_id', 'director', 'release', 'longTime', 'rate', 'img_path', 'pricePerDay', 'available'
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
