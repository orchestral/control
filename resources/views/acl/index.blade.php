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

	@foreach($roles as $roleId => $role)
	<div class="twelve columns panel panel-default">
		<div class="panel-heading">
			{{ $role['name'] }}
		</div>
		<div class="white rounded-bottom box small-padding">
			<div class="row">
			@foreach($actions as $actionId => $action)
				<label for="acl-{!! $roleId !!}-{!! $actionId !!}" class="three columns checkboxes">
					{!! Form::checkbox("acl-{$roleId}-{$actionId}", 'yes', $eloquent->check($role['slug'], $action['slug']), [
						'id' => "acl-{$roleId}-{$actionId}",
					]) !!}
					{{ $action['name'] }}
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
