<?php

$control = Orchestra\Resources::make('control', array(
	'name'       => 'Control',
	'uses'       => 'resource:Orchestra\Control\Routing\RolesController',
	'visibility' => function ()
	{
		return Orchestra\App::acl()->can('manage user');
	}
));

$control['acl']   = 'restful:Orchestra\Control\Routing\AclController';
// $control['theme'] = 'restful:Orchestra\Control\Routing\ThemesController';
