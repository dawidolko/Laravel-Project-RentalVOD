<?php
namespace App\Models;

use App\Enums\RecommendationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'friend_id',
        'movie_id',
        'status',
    ];

    protected $casts = [
        'status' => RecommendationStatus::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function friend()
    {
        return $this->belongsTo(User::class, 'friend_id');
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}
