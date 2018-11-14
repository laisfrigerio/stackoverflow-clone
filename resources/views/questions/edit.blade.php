@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h2>Edit question</h2>
                            <div class="ml-auto">
                                <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">Back to all questions</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('questions.update', $question->id ) }}" method="POST">
                            @csrf
                            {{ method_field('PUT') }}
                            <div class="form-group">
                                <label for="question-title">Title</label>
                                <input id="question-title" name="title" type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : ''  }}" value="{{ old('title', $question->title) }}">

                                @if($errors->has('title'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="question-body">Explain your question</label>
                                <textarea id="question-body" name="body" rows="10" class="form-control {{ $errors->has('body') ? 'is-invalid' : ''  }}">{{ old('body', $question->body) }}</textarea>

                                @if($errors->has('body'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-outline-primary btn-lg">Ask this question</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
