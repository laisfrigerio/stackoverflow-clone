@if($answersCount > 0)
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>{{ $answersCount . " " . str_plural('Answer', $answersCount) }}</h2>
                    </div>
                    <hr>
                    @foreach($answers as $answer)
                        <div class="media">

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
                                        @include('partials._avatar', [
                                            'model' => $answer,
                                            'label' => 'Answered'
                                        ])
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif
