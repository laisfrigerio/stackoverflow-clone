<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoteRequest;
use App\Models\Question;

class VoteQuestionController extends Controller
{
    /**
     * VoteQuestionController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Default method invoked from this controller
     *
     * @param VoteRequest $request
     * @param Question $question
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(VoteRequest $request, Question $question)
    {
        $vote = (int) $request->input('vote');
        $user = auth()->user();
        
        if ($user->questionsVote()->where('votable_id', $question->id)->exists()) {
            $user->questionsVote()->updateExistingPivot($question, [ 'vote' => $vote ]);
        } else {
            $user->questionsVote()->attach($question, [ 'vote' => $vote ]);
        }
        
        return back();
    }
}
