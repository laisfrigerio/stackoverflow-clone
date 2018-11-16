<?php

namespace App\Http\Controllers;

use App\Models\Question;

class FavoriteController extends Controller
{
    /**
     * FavoriteController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Favorite a question
     *
     * @param Question $question
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Question $question)
    {
        $question->favorites()->attach(auth()->id());
        return back();
    }

    /**
     * Unmaking a favorite question
     * @param Question $question
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Question $question)
    {
        $question->favorites()->detach(auth()->id());
        return back();
    }
}
