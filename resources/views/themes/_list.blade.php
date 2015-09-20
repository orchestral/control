@foreach($themes as $id => $theme)
<div class="four columns themes box">
	<img src="{!! asset("themes/{$id}/screenshot.png") !!}" class="img-thumbnail">
	<h3>{{ $theme->name }}</h3>
	<p>{{ $theme->description }}</p>
	<div>
	@if ($id === $current)
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
@endforeach
