<?php

use Illuminate\Routing\Router;
use Orchestra\Support\Facades\Foundation;

Foundation::namespaced('Orchestra\Control\Routing', function (Router $router) {
    $router->group(['prefix' => 'control'], function (Router $router) {
        $router->get('/', 'HomeController@index');

        $router->get('acl', 'AuthorizationController@edit');
        $router->post('acl', 'AuthorizationController@update');
        $router->get('acl/{id}/sync', 'AuthorizationController@sync');

        $router->resource('roles', 'RolesController');

        $router->get('themes', 'ThemesController@index');
        $router->get('themes/backend', 'ThemesController@backend');
        $router->get('themes/frontend', 'ThemesController@frontend');
        $router->get('themes/{type}/{id}/activate', [
            'uses' => 'ThemesController@activate',
            'where' => ['type' => '(backend|frontend)'],
        ]);
    });
});
