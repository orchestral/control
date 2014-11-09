<?php

use Illuminate\Routing\Router;
use Orchestra\Support\Facades\Foundation;

/*
|--------------------------------------------------------------------------
| Control Resources Route
|--------------------------------------------------------------------------
|
| Register Control Extension as a resources.
|
*/

Foundation::namespaced('Orchestra\Control\Routing', function (Router $router) {
    $router->group(['prefix' => 'control'], function (Router $router) {
        $router->get('/', 'HomeController@index');

        $router->get('acl', 'AclController@getIndex');
        $router->post('acl', 'AclController@postIndex');
        $router->get('acl/sync', 'AclController@getSync');

        $router->resource('roles', 'RolesController');

        $router->get('themes', 'ThemeController@getIndex');
        $router->get('themes/backend', 'ThemeController@getBackend');
        $router->get('themes/frontend', 'ThemeController@getFrontend');
        $router->get('themes/activate/{type}/{id}', 'ThemeController@getActivate');
    });
});

Event::listen('orchestra.started: admin', function () {
    Foundation::menu()->add('control', '<:extension')
        ->title('Control')
        ->link(handles('orchestra::control'));
});
