<a
    title="Click to mark as favorite {{ $name }} (Click again to undo)"
    class="favorite mt-2 {{ Auth::guest() ? 'off' : ($model->isFavorited() ? 'favorited' : '') }}"
    onclick="event.preventDefault(); document.getElementById('favorite-{{ $name }}-{{ $model->id }}').submit()"
>
    <i class="fas fa-star fa-2x"></i>
    <span class="favorites-count">{{ $model->favorites_count }}</span>
</a>
<form style="display: none" id="favorite-{{ $name }}-{{ $model->id }}" action="/{{ $uri  }}/{{ $model->id }}/favorite" method="POST">
    @csrf
    @if($model->isFavorited())
    @method('DELETE')
    @endif
</form>
