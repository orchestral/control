@foreach ($themes as $id => $theme)
<div class="four columns white themes box">
    <img src="{{ asset("themes/{$id}/screenshot.png") }}" class="img-thumbnail">
    <h3>{{ $theme->name }}</h3>
    <p>{{ $theme->description }}</p>
    <div>
    @if ($id === $current)
        <button class="btn btn-block btn-warning disabled">
            {{ trans('orchestra/control::label.themes.current') }}
        </button>
    @else
        <a href="{{ resources("control.themes/activate/{$type}/{$id}") }}" class="btn btn-block btn-primary">
            {{ trans('orchestra/control::label.themes.activate') }}
        </a>
    @endif
    </div>
</div>
@endforeach
