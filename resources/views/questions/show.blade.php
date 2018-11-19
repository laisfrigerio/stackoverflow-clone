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

                                @include('partials._vote', [
                                    'model'      => $question,
                                    'name'       => 'question',
                                    'uri'        => 'questions'
                                ])

                                @include('partials._favorite', [
                                    'model' => $question,
                                    'name'  => 'question',
                                    'uri'    => 'questions'
                                ])
                            </div>

                            <div class="media-body">
                                {!! $question->body_html !!}
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        @include('partials._avatar', [
                                            'model' => $question,
                                            'label' => 'Asked'
                                        ])
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
