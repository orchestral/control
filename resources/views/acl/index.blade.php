@extends('orchestra/foundation::layouts.page')

#{{ use Orchestra\Support\Str }}

@section('content')
@include('orchestra/control::widgets.header')

<div class="row">
	<div class="navbar user-search hidden-phone">
		{!! Form::open(['url' => app('url')->current(), 'method' => 'GET', 'class' => 'navbar-form']) !!}
			{!! Form::select('name', $collection, $metric, ['class' => '']) !!}&nbsp;
			<button type="submit" class="btn btn-primary">{{ trans('orchestra/foundation::label.submit') }}</button>
		{!! Form::close() !!}
	</div>

	{!! Form::open(['url' => app('url')->current(), 'method' => 'POST']) !!}
	{!! Form::hidden('metric', $metric) !!}

	@foreach ($roles as $roleKey => $roleName)
	<div class="twelve columns panel panel-default">
		<div class="panel-heading">
			{{ Str::humanize($roleName) }}
		</div>
		<div class="white rounded-bottom box small-padding">
			<div class="row">
			@foreach($actions as $actionKey => $actionName)
				<label for="acl-{!! $roleKey !!}-{!! $actionKey !!}" class="three columns checkboxes">
					{!! Form::checkbox("acl-{$roleKey}-{$actionKey}", 'yes', $eloquent->check($roleName, $actionName), [
						'id' => "acl-{$roleKey}-{$actionKey}",
					]) !!}
					{{ Str::humanize($actionName) }}
					&nbsp;&nbsp;&nbsp;
				</label>
			@endforeach
			</div>
		</div>
	</div>
	@endforeach

	<div class="row">
		<div class="twelve columns">
			<button type="submit" class="btn btn-primary">{{ trans('orchestra/foundation::label.submit') }}</button>
			<a href="{!! handles("orchestra::control/acl/{$metric}/sync", ['csrf' => true]) !!}" class="btn btn-link">
				{{ trans('orchestra/control::label.sync-roles') }}
			</a>
		</div>
	</div>
	{!! Form::close() !!}
</div>
@stop
