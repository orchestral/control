<?php namespace Orchestra\Control\Routing;

use Illuminate\Support\Facades\View;
use Orchestra\Model\Role;

class RolesController extends BaseController {

	/**
	 * List all the roles
	 *
	 * @access public
	 * @return Response
	 */
	public function index()
	{
		$roles = Role::paginate(30);
		return View::make('orchestra/control::roles.index', compact('roles'));
	}
}
