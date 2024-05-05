<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movies extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'loan_movie'; // Nazwa tabeli w bazie danych

    protected $fillable = [
        'id', 'loan_id', 'movie_id'
    ];
}