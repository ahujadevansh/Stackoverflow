<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;

class FavouritesController extends Controller
{
    public function store(Question $question)
    {
        $question->favourites()->attach(auth()->id());
        return redirect()->back();
    }

    public function destroy(Question $question)
    {
        $question->favourites()->detach(auth()->id());
        return redirect()->back();
    }
}
