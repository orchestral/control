<?php namespace Orchestra\Control\Routing;

use Illuminate\Support\Facades\View;
use Orchestra\Control\Services\RolePresenter;
use Orchestra\Model\Role;
use Orchestra\Site;

class RolesController extends BaseController {
	/**
	 * Define the filters.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		$this->beforeFilter('orchestra.manage:roles');
	}

	/**
	 * List all the roles
	 *
	 * @access public
	 * @return Response
	 */
	public function index()
	{
		$roles = Role::paginate(30);
		$table = RolePresenter::table($roles);

		Site::set('title', trans('orchestra/control::title.roles.list'));

		return View::make('orchestra/control::roles.index', compact('roles', 'table'));
	}
}
