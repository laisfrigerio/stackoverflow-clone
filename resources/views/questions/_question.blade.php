<div class="media post">
    <div class="d-flex flex-column counters">
        <div class="vote">
            <strong>{{ $question->votes_count }}</strong> {{ str_plural('vote', $question->votes_count) }}
        </div>
        <div class="status {{ $question->status }}">
            <strong>{{ $question->answers_count }}</strong> {{ str_plural('answer', $question->answers_count) }}
        </div>
        <div class="view">
            {{ $question->views . " " . str_plural('view', $question->views) }}
        </div>
    </div>
    <div class="media-body">
        <div class="d-flex align-items-center">
            <h3 class="mt-0"><a href="{{ $question->url }}">{{ $question->title }}</a></h3>

            <div class="ml-auto">

                @can('update', $question)
                    <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-sm btn-primary">Edit</a>
                @endcan

                @can('delete', $question)
                    <form class="form-delete" action="{{ route('questions.destroy', $question->id) }}" method="post">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger" onClick="return confirm('Are you sure')">Delete</button>
                    </form>
                @endcan
            </div>

        </div>

        <p class="lead">
            Asked by
            <a href="{{ $question->url }}">{{ $question->user->name }}</a>
            <small class="text-muted">{{ $question->created_date }}</small>
        </p>
        <div class="excerpt">
            {{ str_limit(strip_tags($question->body_html), 300) }}
        </div>
    </div>
</div>
