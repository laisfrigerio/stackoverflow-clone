<form style="display: none" id="favorite-{{ $name }}-{{ $model->id }}" action="/{{ $uri  }}/{{ $model->id }}/favorite" method="POST">
    @csrf
    @if($model->isFavorited())
    @method('DELETE')
    @endif
</form>
