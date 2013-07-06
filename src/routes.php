<?php

use Orchestra\Support\Facades\App;
use Orchestra\Support\Facades\Resources;

$control = Resources::make('control', array(
	'name'    => 'Control',
	'uses'    => 'restful:Orchestra\Control\Routing\HomeController',
	'visible' => function ()
	{
		$acl = App::acl();
		return ($acl->can('manage acl') or $acl->can('manage roles'));
	}
));

$control['roles']  = 'resource:Orchestra\Control\Routing\RolesController';
$control['acl']    = 'restful:Orchestra\Control\Routing\AclController';
$control['themes'] = 'restful:Orchestra\Control\Routing\ThemesController';
