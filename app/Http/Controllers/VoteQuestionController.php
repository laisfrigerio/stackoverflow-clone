<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoteRequest;
use App\Models\Question;
use App\Services\VoteService;

class VoteQuestionController extends Controller
{
    /**
     * @var VoteService
     */
    private $voteService;

    /**
     * VoteQuestionController constructor.
     * @param VoteService $voteService
     */
    public function __construct(VoteService $voteService)
    {
        $this->middleware('auth');
        $this->voteService = $voteService;
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
        $votesCount = $this->voteService->vote($request->user()->questionsVote(), $question, $vote);

        if (request()->expectsJson()) {
            return response()->json([
                'message' => 'Thanks for the feedback',
                'votesCount' => $votesCount
            ]);
        }
        
        return back();
    }
}
