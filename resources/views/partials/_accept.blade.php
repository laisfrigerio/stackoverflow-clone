@can('accept', $model)
    <a
        title="Mark this answer as best answer"
        class="{{ $model->status }} mt-2 answer-accepted-{{ $model->id }}"
        onclick="event.preventDefault(); document.getElementById('answer-accepted-{{ $model->id }}').submit()"
    >
        <i class="fas fa-check fa-2x"></i>
    </a>
    <form id="answer-accepted-{{ $model->id }}" action="{{ route($uri . '.accept', $model->id) }}" method="POST" style="display: none">
        @csrf
    </form>
@else
    @if($model->isBest())
        <a
            title="The question owner accepted this answer as best answer"
            class="{{ $model->status }} mt-2 answer-accepted-{{ $model->id }}"
        >
            <i class="fas fa-check fa-2x"></i>
        </a>
    @endif
@endcan
