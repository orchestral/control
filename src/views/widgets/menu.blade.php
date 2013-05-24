@section('orchestra/control::primary_menu')
<ul class="nav">
	@if (Orchestra\App::acl()->can('manage-roles'))
	<li class="{{ URI::is('*/resources/control.roles*') ? 'active' : '' }}">
		{{ HTML::link(handles('orchestra::resources/control.roles'), 'Roles') }}
	</li>
	@endif
	@if (Orchestra\App::acl()->can('manage-acl'))
	<li class="{{ URI::is('*/resources/control.acls*') ? 'active' : '' }}">
		{{ HTML::link(handles('orchestra::resources/control.acls'), 'ACL') }}
	</li>
	@endif
</ul>
@endsection

<?php

$navbar = new Illuminate\Support\Fluent(array(
	'id'           => 'control',
	'title'        => 'Control',
	'url'          => handles('orchestra::resources/control'),
	'primary_menu' => View::yieldContent('orchestra/control::primary_menu'),
)); ?>

@decorator('navbar', $navbar)
