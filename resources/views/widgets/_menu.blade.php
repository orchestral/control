#{{ $acl = app('orchestra.platform.acl') }}

<ul class="nav navbar-nav">
	@if ($acl->can('manage-roles'))
	<li class="{{ app('request')->is('*control/roles*') ? 'active' : '' }}">
		<a href="{{ handles('orchestra::control/roles') }}">Roles</a>
	</li>
	@endif

	@if ($acl->can('manage-acl'))
	<li class="{{ app('request')->is('*control/acl*') ? 'active' : '' }}">
		 <a href="{{ handles('orchestra::control/acl') }}">ACL</a>
	</li>
	@endif

	@if ($acl->can('manage-orchestra'))
	<li class="dropdown{{ app('request')->is('*control/themes*') ? ' active' : '' }}">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Themes</a>
		<ul class="dropdown-menu">
			<li>
				<a href="{{ handles('orchestra::control/themes/frontend') }}">Frontend</a>
			</li>
			<li>
				<a href="{{ handles('orchestra::control/themes/backend') }}">Backend</a>
			</li>
		</ul>
	</li>
	@endif
</ul>
