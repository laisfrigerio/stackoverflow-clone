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

                                <vote :model="{{ $question }}" name="question"></vote>

                                <favorite :question="{{ $question }}"></favorite>
                            </div>

                            <div class="media-body">
                                {!! $question->body_html !!}
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <avatar label='Asked' :model="{{ $question  }}"></avatar>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <answers :question="{{ $question }}"></answers>

        @include('answers._create')

    </div>
@endsection
