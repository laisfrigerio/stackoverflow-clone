<?php

namespace App\Http\Controllers;

use App\Http\Requests\AskQuestionRequest;
use App\Models\Question;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::latest()->with('user')->paginate(5);
        return view('questions.index')->with(['questions' => $questions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $question = new Question();
        return view('questions.create')->with(['question' => $question]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AskQuestionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AskQuestionRequest $request)
    {
        $request->user()->questions()->create($request->only('title', 'body'));
        return redirect()->route('questions.index')->with(['success' => 'Your question has been submitted']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        $question->increment('views');
        return view('questions.show')->with(['question' => $question]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question $question
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Question $question)
    {
        $this->authorize('update', $question);
        return view('questions.edit')->with(['question' => $question]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AskQuestionRequest $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(AskQuestionRequest $request, Question $question)
    {
        $question->update($request->only('title', 'body'));

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Your question has been updated',
                'body_html' => $question->body_html
            ]);
        }

        return redirect()->route('questions.index')->with(['success' => 'Your question has been updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question $question
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Question $question)
    {
        $this->authorize('delete', $question);
        $question->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'message' => 'Your question has been deleted'
            ]);
        }

        return redirect()->route('questions.index')->with(['success' => 'Your question has been deleted']);
    }
}
