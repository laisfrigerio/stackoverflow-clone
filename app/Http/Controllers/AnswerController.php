<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * Show all answers from a specific question
     *
     * @param Question $question
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function index(Question $question)
    {
        return $question->answers()->with('user')->simplePaginate(3);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param Question $question
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Question $question, Request $request)
    {
        $request->validate([
            'body' => 'required|string'
        ]);
        
        $answer = $question->answers()->create([
            'body' => $request->input('body'),
            'user_id' => Auth::user()->id
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Your answer has been submitted',
                'answer' => $answer->load('user')
            ]);
        }
        
        return back()->with(['success' => 'Your answer has been submitted']);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question $question
     * @param Answer $answer
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);
        return view('answers.edit')->with(['question' => $question, 'answer' => $answer]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param Question $question
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Answer $answer
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);
        
        $answer->update(
            $request->validate([
                'body' => 'required|string'
            ])
        );
        
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Your answer has been updated',
                'body_html' => $answer->body_html
            ]);
        }

        return redirect()->route('questions.show', $question->slug)->with(['success' => 'Your answer has been updated']);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param Question $question
     * @param  \App\Models\Answer $answer
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(Question $question,  Answer $answer)
    {
        $this->authorize('delete', $answer);
        $answer->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'message' => 'Your answer has been removed'
            ]);
        }

        return back()->with(['success' => 'Your answer has been removed']);
    }
}
