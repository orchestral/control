@include('orchestra/control::widgets.menu')

<div class="row">
	
	@include('orchestra/foundation::layout.widgets.header')

	<div class="navbar hidden-phone">
		{{ Form::open(array('url' => URL::current(), 'method' => 'GET', 'class' => 'navbar-form')) }}
			{{ Form::select('name', $lists, $selected, array('class' => '')) }}&nbsp;
			<button type="submit" class="btn btn-primary">{{ trans('orchestra/foundation::label.submit') }}</button>
		{{ Form::close() }}
	</div>

	<br>

	{{ Form::open(array('url' => URL::current(), 'method' => 'POST')) }}
		{{ Form::hidden('metric', $selected) }}
		<div class="accordion" id="acl-accordion">
		@foreach ($eloquent->roles()->get() as $roleKey => $roleName)
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle" data-toggle="collapse" 
						data-parent="#acl-accordion" href="#collapse{{ $roleKey }}">
						{{ Orchestra\Support\Str::humanize($roleName) }}
					</a>
				</div>
				<div id="collapse{{ $roleKey }}" class="accordion-body collapse in">
					<div class="accordion-inner">
						@foreach($eloquent->actions()->get() as $actionKey => $actionName)
							<label for="acl-{{ $roleKey }}-{{ $actionKey }}" class="checkbox-inline">
								{{ Form::checkbox("acl-{$roleKey}-{$actionKey}", 'yes', $eloquent->check($roleName, $actionName), array('id' => "acl-{$roleKey}-{$actionKey}")) }}
								{{ Orchestra\Support\Str::humanize($actionName) }}&nbsp;&nbsp;&nbsp;
							</label>
						@endforeach
					</div>
				</div>
			</div>
		@endforeach
		</div>
		<div class="form-actions">
			<button type="submit" class="btn btn-primary">{{ trans('orchestra/foundation::label.submit') }}</button>
			<a href="{{ handles("orchestra/foundation::resources/control.acl/sync/{$selected}") }}" class="btn">
				{{ trans('orchestra/control::label.sync-roles') }}
			</a>
		</div>
	{{ Form::close() }}
</div>
