<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'control'], function (Router $router) {
    $router->get('/', 'HomeController@index');

    $router->get('acl', 'AuthorizationController@edit');
    $router->post('acl', 'AuthorizationController@update');
    $router->get('acl/{vendor}/{package}/sync', 'AuthorizationController@sync');
    $router->get('acl/{vendor}/sync', 'AuthorizationController@sync');

    $router->resource('roles', 'RolesController');
    $router->match(['GET', 'HEAD', 'DELETE'], 'roles/{roles}/delete', 'RolesController@delete');

    $router->get('themes', 'ThemesController@index');
    $router->get('themes/backend', 'ThemesController@backend');
    $router->get('themes/frontend', 'ThemesController@frontend');
    $router->get('themes/{type}/{id}/activate', [
        'uses'  => 'ThemesController@activate',
        'where' => ['type' => '(backend|frontend)'],
    ]);
});
