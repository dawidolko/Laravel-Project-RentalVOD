<?php

namespace App\Http\Controllers;

use App\Models\Opinion;
use App\Models\Loan;
use App\Http\Requests\StoreOpinionRequest;
use Illuminate\Support\Facades\Auth;

class OpinionController extends Controller
{
    public function store(StoreOpinionRequest $request)
    {
        $validatedData = $request->validated();

        $userLoan = Loan::where('user_id', Auth::id())
                        ->whereHas('movies', function($query) use ($validatedData) {
                            $query->where('movies.id', $validatedData['movie_id']);
                        })->exists();

        if (!$userLoan) {
            return back()->with('error', 'Nie możesz dodać opinii do filmu, którego nie wypożyczyłeś.');
        }

        $existingOpinion = Opinion::where('movie_id', $validatedData['movie_id'])
                                  ->where('user_id', auth()->id())
                                  ->first();

        if ($existingOpinion) {
            return back()->with('error', 'Możesz dodać tylko jedną opinię dla tego filmu.');
        }

        $opinion = new Opinion();
        $opinion->movie_id = $validatedData['movie_id'];
        $opinion->user_id = auth()->id();
        $opinion->content = $validatedData['content']; 
        $opinion->save();

        return back()->with('success', 'Opinia została dodana.');
    }    
}
