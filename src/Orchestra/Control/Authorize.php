<?php namespace Orchestra\Control;

use Orchestra\Support\Facades\Acl;
use Orchestra\Model\Role;

class Authorize {
	
	/**
	 * Re-sync administrator access control.
	 *
	 * @static
	 * @access public
	 * @return void
	 */
	public static function sync()
	{
		$acl   = Acl::make('orchestra');
		$admin = Role::admin();

		$acl->allow($admin->name, array('Manage Users', 'Manage Orchestra', 'Manage Roles', 'Manage Acl'));
	}
}
