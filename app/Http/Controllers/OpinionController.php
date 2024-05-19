<?php

namespace App\Http\Controllers;

use App\Models\Opinion;
use App\Http\Requests\StoreOpinionRequest;

class OpinionController extends Controller
{
    public function store(StoreOpinionRequest $request)
    {
        $validatedData = $request->validated();

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
