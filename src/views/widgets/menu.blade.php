@section('authorize::primary_menu')
<ul class="nav">
	@if (Orchestra::acl()->can('manage-roles'))
	<li class="{{ URI::is('*/resources/authorize.roles*') ? 'active' : '' }}">
		{{ HTML::link(handles('orchestra::resources/authorize.roles'), 'Roles') }}
	</li>
	@endif
	@if (Orchestra::acl()->can('manage-acl'))
	<li class="{{ URI::is('*/resources/authorize.acls*') ? 'active' : '' }}">
		{{ HTML::link(handles('orchestra::resources/authorize.acls'), 'ACL') }}
	</li>
	@endif
</ul>
@endsection


<?php

$navbar = new Orchestra\Fluent(array(
	'id'             => 'authorize',
	'title'          => 'Authorize',
	'url'            => handles('orchestra::resources/authorize'),
	'primary_menu'   => Laravel\Section::yield('authorize::primary_menu'),
)); ?>

{{ Orchestra\Decorator::navbar($navbar) }}
