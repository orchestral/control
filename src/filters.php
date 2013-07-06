<?php

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
	if ( ! App::acl()->can("manage-{$value}"))
	{
		$redirect = (Auth::guest() ? 'login' : '/');
		
		Redirect::to(handles("orchestra::{$redirect}"));
	}
});
