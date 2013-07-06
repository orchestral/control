<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirecta;
use Illuminate\Support\Facades\Route;
use Orchestra\Support\Facades\App;

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

Route::filter('control.manage', function ($route, $request, $value = 'orchestra')
{
	$guest = Auth::guest();

	if ( ! App::acl()->can("manage-{$value}") or $guest)
	{
		$redirect = ($guest ? 'login' : '/');
		
		Redirect::to(handles("orchestra::{$redirect}"));
	}
});
