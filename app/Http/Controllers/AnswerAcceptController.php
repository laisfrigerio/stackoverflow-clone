<?php

namespace App\Http\Controllers;

use App\Models\Answer;

/**
 * Single action controller
 *
 * Class AnswerAcceptController
 * @package App\Http\Controllers
 */
class AnswerAcceptController extends Controller
{
    /**
     * Only one method - default method invoked
     * @param Answer $answer
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Answer $answer)
    {
        $this->authorize('accept', $answer);
        $question = $answer->question;
        $question->best_answer_id = $answer->id;
        $question->save();

        if (request()->expectsJson()) {
            return response()->json([
                'message' => 'You have accepted this answer as best answer'
            ]);
        }

        return back()->with(['success' => 'Answer accepted as best answer']);
    }
}
