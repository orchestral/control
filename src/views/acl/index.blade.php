@include('orchestra/control::widgets.menu')

<div class="row-fluid">
	
	@include('orchestra/foundation::layout.widgets.header')

	<div class="navbar hidden-phone">
		<div class="navbar-inner">
			{{ Form::open(array('url' => URL::current(), 'method' => 'GET', 'class' => 'navbar-form')) }}
				<div class="pull-left">
					{{ Form::select('name', $lists, $selected, array('class' => '')) }}&nbsp;
				</div>
				<div class="pull-left">
					<button type="submit" class="btn btn-primary">{{ __('orchestra/foundation::label.submit') }}</button>
				</div>
			{{ Form::close() }}
		</div>
	</div>

	{{ Form::open(array('url' => URL::current(), 'method' => 'POST')) }}
		{{ Form::hidden('metric', $selected) }}
		<div class="accordion" id="acl-accordion">
		@foreach ($eloquent->roles()->get() as $roleKey => $roleName)
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle" data-toggle="collapse" 
						data-parent="#acl-accordion" href="#collapse{{ $roleKey }}">
						{{ $roleName }}
					</a>
				</div>
				<div id="collapse{{ $roleKey }}" class="accordion-body collapse in">
					<div class="accordion-inner">
						@foreach($eloquent->actions()->get() as $actionKey => $actionName)
							<label for="acl-{{ $roleKey }}-{{ $actionKey }}" class="checkbox inline">
								{{ Form::checkbox("acl-{$roleKey}-{$actionKey}", 'yes', $eloquent->check($roleName, $actionName), array('id' => "acl-{$roleKey}-{$actionKey}")) }}
								{{ $actionName }}&nbsp;&nbsp;&nbsp;
							</label>
						@endforeach
					</div>
				</div>
			</div>
		@endforeach
		</div>
		<div class="form-actions">
			<button type="submit" class="btn btn-primary">{{ __('orchestra/foundation::label.submit') }}</button>
			<a href="{{ handles("orchestra/foundation::resources/control.acl/sync/{$selected}") }}" class="btn">
				{{ trans('orchestra/control::label.sync-roles') }}
			</a>
		</div>
	{{ Form::close() }}
</div>
