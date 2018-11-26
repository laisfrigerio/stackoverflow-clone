<div class="media post">
    <div class="d-flex flex-column vote-controls">
        @include('partials._vote', [
                'model'      => $answer,
                'name'       => 'answer',
                'uri'        => 'answers'
            ])

        @include('partials._accept', [
            'model' => $answer,
            'uri'   => 'answers'
        ])
    </div>
    <div class="media-body">
        {!! $answer->body_html !!}
        <div class="row">
            <div class="col-4">
                <div class="ml-auto">
                    @can('update', $answer)
                        <a href="{{ route('questions.answers.edit', [$question->id, $answer->id]) }}" class="btn btn-sm btn-primary">Edit</a>
                    @endcan
                    @can('delete', $answer)
                        <form class="form-delete" action="{{ route('questions.answers.destroy', [$question->id, $answer->id]) }}" method="post">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger" onClick="return confirm('Are you sure')">Delete</button>
                        </form>
                    @endcan
                </div>
            </div>
            <div class="col-4"></div>
            <div class="col-4">
                <avatar label='Answered' :model="{{ $answer  }}"></avatar>
            </div>
        </div>
    </div>
</div>
