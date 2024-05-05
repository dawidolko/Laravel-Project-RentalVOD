<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opinion;

class OpinionController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'content' => 'required|min:1', 
        ]);
    
        $opinion = new Opinion();
        $opinion->movie_id = $request->movie_id;
        $opinion->user_id = auth()->id();
        $opinion->content = $validatedData['content']; 
        $opinion->save();
    
        return back()->with('success', 'Opinia została dodana.');
    }    
}
