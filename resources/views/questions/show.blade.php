@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @include('layouts._messages')
                        <div class="card-title">
                            <div class="d-flex align-items-center">
                                <h1>{{ $question->title }}</h1>
                                <div class="ml-auto">
                                    <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">Back to all questions</a>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="media">

                            <div class="d-flex flex-column vote-controls">

                                <a title="This question is useful?"
                                   class="vote-up {{ Auth::guest() ? 'off' : '' }}"
                                   onclick="event.preventDefault(); document.getElementById('vote-up-question-{{ $question->id }}').submit()"
                                >
                                    <i class="fas fa-caret-up fa-3x"></i>
                                </a>
                                <form style="display: none"
                                      id="vote-up-question-{{ $question->id }}"
                                      action="{{ route('questions.vote', $question->id) }}"
                                      method="POST"
                                >
                                    @csrf
                                    <input type="hidden" name="vote" value="1">
                                </form>

                                <span class="votes-count">{{ $question->votes_count }}</span>

                                <a title="This question is not useful?"
                                   class="vote-down {{ Auth::guest() ? 'off' : '' }}"
                                   onclick="event.preventDefault(); document.getElementById('vote-down-question-{{ $question->id }}').submit()"
                                >
                                    <i class="fas fa-caret-down fa-3x"></i>
                                </a>
                                <form style="display: none"
                                      id="vote-down-question-{{ $question->id }}"
                                      action="{{ route('questions.vote', $question->id) }}"
                                      method="POST"
                                >
                                    @csrf
                                    <input type="hidden" name="vote" value="-1">
                                </form>

                                <a
                                    title="Click to mark as favorite question (Click again to undo)"
                                    class="favorite mt-2 {{ Auth::guest() ? 'off' : ($question->isFavorited() ? 'favorited' : '') }}"
                                    onclick="event.preventDefault(); document.getElementById('favorite-question-{{ $question->id }}').submit()"
                                >
                                    <i class="fas fa-star fa-2x"></i>
                                    <span class="favorites-count">{{ $question->favorites_count }}</span>
                                </a>
                                <form style="display: none" id="favorite-question-{{ $question->id }}" action="/questions/{{ $question->id }}/favorite" method="POST">
                                    @csrf
                                    @if($question->isFavorited())
                                        @method('DELETE')
                                    @endif
                                </form>
                            </div>

                            <div class="media-body">
                                {!! $question->body_html !!}
                                <div class="float-right">
                                    <span class="text-muted">Answered {{ $question->created_date }}</span>
                                    <div class="media mt-2">
                                        <a href="{{ $question->user->url }}" class="pr-2">
                                            <img src="{{ $question->user->avatar }}">
                                        </a>
                                        <div class="media-body mt-1">
                                            <a href="{{ $question->user->url }}">{{ $question->user->name }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('answers._index', [
            'answers'      => $question->answers,
            'answersCount' => $question->answers_count
        ])

        @include('answers._create')

    </div>
@endsection
