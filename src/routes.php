<?php

$control = Orchestra\Resources::make('control', array(
	'name'       => 'Control',
	'uses'       => 'restful:Orchestra\Control\Routing\HomeController',
	'visibility' => function ()
	{
		return Orchestra\App::acl()->can('manage user');
	}
));

$control['roles']  = 'resource:Orchestra\Control\Routing\RolesController';
$control['acl']    = 'restful:Orchestra\Control\Routing\AclController';
$control['themes'] = 'restful:Orchestra\Control\Routing\ThemesController';
