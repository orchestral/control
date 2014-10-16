<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Orchestra\Support\Facades\Foundation;

/*
|--------------------------------------------------------------------------
| ACL Filter
|--------------------------------------------------------------------------
|
| The ACL filter would check against our RBAC metric to ensure that only
| user with the right authorization can access certain part of the
| application.
|
*/

Route::filter('control.manage', function ($route, $request, $value = 'orchestra') {
    $guest = Auth::guest();

    if (! Foundation::acl()->can("manage-{$value}") or $guest) {
        $redirect = ($guest ? 'login' : '/');

        return Redirect::to(handles("orchestra::{$redirect}"));
    }
});
