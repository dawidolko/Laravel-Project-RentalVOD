<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecommendMovieRequest;
use App\Models\Recommendation;
use App\Models\Friendship;
use App\Enums\RecommendationStatus;
use App\Enums\FriendshipStatus;
use Illuminate\Support\Facades\Auth;

class MovieRecommendationController extends Controller
{
    public function recommendMovie(RecommendMovieRequest $request, $movieId)
    {
        $friendId = $request->input('friend_id');
        $userId = Auth::id();

        $friendshipExists = Friendship::where(function ($query) use ($userId, $friendId) {
            $query->where('user_id', $userId)->where('friend_id', $friendId)->where('status', FriendshipStatus::Accepted);
        })->orWhere(function ($query) use ($userId, $friendId) {
            $query->where('user_id', $friendId)->where('friend_id', $userId)->where('status', FriendshipStatus::Accepted);
        })->exists();

        if (!$friendshipExists) {
            return back()->with('error', 'Nie możesz polecić filmu osobie, która nie jest Twoim znajomym.');
        }

        $existingRecommendation = Recommendation::where('user_id', $userId)
            ->where('friend_id', $friendId)
            ->where('movie_id', $movieId)
            ->exists();

        if ($existingRecommendation) {
            return back()->with('error', 'Ten film został już polecony tej osobie.');
        }

        Recommendation::create([
            'user_id' => $userId,
            'friend_id' => $friendId,
            'movie_id' => $movieId,
            'status' => RecommendationStatus::Recommended
        ]);

        return back()->with('success', 'Film został polecony znajomemu.');
    }
}
