@forelse($themes as $id => $theme)
<div class="col-md-4">
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="text-center">
        <img src="{!! asset("themes/{$id}/screenshot.png") !!}" class="img-thumbnail ">
      </div>
      <h3>{{ $theme->name }}</h3>
      <p>{{ $theme->description }}</p>
      <div>
      @if($id === $current)
        <button class="btn btn-block btn-warning disabled">
          {{ trans('orchestra/control::label.themes.current') }}
        </button>
      @else
        <a href="{!! handles("orchestra::control/themes/{$type}/{$id}/activate", ['csrf' => true]) !!}" class="btn btn-block btn-primary">
          {{ trans('orchestra/control::label.themes.activate') }}
        </a>
      @endif
      </div>
    </div>
  </div>
</div>
@empty
  @include('orchestra/control::themes._empty')
@endforelse
