<a title="This {{ $name }} is useful?"
   class="vote-up {{ Auth::guest() ? 'off' : '' }}"
   onclick="event.preventDefault(); document.getElementById('vote-up-{{ $name }}-{{ $model->id }}').submit()"
>
    <i class="fas fa-caret-up fa-3x"></i>
</a>
<form style="display: none"
      id="vote-up-{{ $name }}-{{ $model->id }}"
      action="{{ route($uri .'.vote', $model->id) }}"
      method="POST"
>
    @csrf
    <input type="hidden" name="vote" value="1">
</form>

<span class="votes-count">{{ $model->votes_count }}</span>

<a title="This {{ $name }} is not useful?"
   class="vote-down {{ Auth::guest() ? 'off' : '' }}"
   onclick="event.preventDefault(); document.getElementById('vote-down-{{ $name }}-{{ $model->id }}').submit()"
>
    <i class="fas fa-caret-down fa-3x"></i>
</a>
<form style="display: none"
      id="vote-down-{{ $name }}-{{ $model->id }}"
      action="{{ route($uri . '.vote', $model->id) }}"
      method="POST"
>
    @csrf
    <input type="hidden" name="vote" value="-1">
</form>
