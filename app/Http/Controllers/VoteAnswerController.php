<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoteRequest;
use App\Models\Answer;
use Illuminate\Http\Request;

class VoteAnswerController extends Controller
{
    /**
     * VoteAnswerController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Default method invoked from this controller
     *
     * @param VoteRequest $request
     * @param Answer $answer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(VoteRequest $request, Answer $answer)
    {
        $vote = (int) $request->input('vote');
        $user = $request->user();
        
        if ($user->answersVote()->where('votable_id', $answer->id)->exists()) {
            $user->answersVote()->updateExistingPivot($answer, [ 'vote' => $vote ]);
        } else {
            $user->answersVote()->attach($answer, [ 'vote' => $vote ]);
        }
        
        return back();
    }
}
