<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendFriendRequest;
use App\Http\Requests\SearchUsersRequest;
use App\Models\Friendship;
use App\Models\User;
use App\Enums\FriendshipStatus;
use Illuminate\Support\Facades\Auth;

class FriendshipController extends Controller
{
    public function sendRequest(SendFriendRequest $request)
    {
        $friend = User::where('email', $request->email)->first();
        if ($friend && $friend->id !== Auth::id()) {
            $existingFriendship = Friendship::where(function ($query) use ($friend) {
                $query->where('user_id', Auth::id())
                      ->where('friend_id', $friend->id)
                      ->whereIn('status', [FriendshipStatus::Pending, FriendshipStatus::Accepted]);
            })->orWhere(function ($query) use ($friend) {
                $query->where('user_id', $friend->id)
                      ->where('friend_id', Auth::id())
                      ->whereIn('status', [FriendshipStatus::Pending, FriendshipStatus::Accepted]);
            })->first();

            if ($existingFriendship) {
                return back()->with('error', 'Już wysłałeś zaproszenie do tej osoby lub jest ona już Twoim znajomym.');
            }

            Friendship::create([
                'user_id' => Auth::id(),
                'friend_id' => $friend->id,
                'status' => FriendshipStatus::Pending
            ]);

            return back()->with('success', 'Wysłano zaproszenie do znajomych.');
        }

        return back()->with('error', 'Nie można wysłać zaproszenia do znajomych.');
    }

    public function acceptRequest($friendshipId)
    {
        $friendship = Friendship::findOrFail($friendshipId);
        $friendship->status = FriendshipStatus::Accepted;
        $friendship->save();

        Friendship::updateOrCreate(
            ['user_id' => $friendship->friend_id, 'friend_id' => $friendship->user_id],
            ['status' => FriendshipStatus::Accepted]
        );

        return back()->with('success', 'Zaakceptowano zaproszenie do znajomych.');
    }

    public function declineRequest($friendshipId)
    {
        $friendship = Friendship::findOrFail($friendshipId);
        $friendship->delete();

        return back()->with('success', 'Odrzucono zaproszenie do znajomych.');
    }

    public function searchUsers(SearchUsersRequest $request)
    {
        $query = $request->get('q');
        $users = User::where('email', 'LIKE', "%{$query}%")->get(['id', 'email']);
        return response()->json($users);
    }

    public function removeFriend($friendId)
    {
        $user = Auth::id();

        Friendship::where('user_id', $user)->where('friend_id', $friendId)->delete();
        Friendship::where('user_id', $friendId)->where('friend_id', $user)->delete();

        return back()->with('success', 'Usunięto znajomego.');
    }
}
