<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoteRequest;
use App\Models\Answer;
use App\Services\VoteService;
use Illuminate\Http\Request;

class VoteAnswerController extends Controller
{
    /**
     * @var VoteService
     */
    private $voteService;

    /**
     * VoteAnswerController constructor.
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
     * @param Answer $answer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(VoteRequest $request, Answer $answer)
    {
        $vote = (int) $request->input('vote');
        $this->voteService($request->user()->answersVote(), $answer, $vote);
        return back();
    }
}
