<?php namespace Orchestra\Control\Routing;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Orchestra\Model\Role;
use Orchestra\Support\Facades\App;
use Orchestra\Support\Facades\Acl;
use Orchestra\Support\Facades\Messages;
use Orchestra\Support\Facades\Site;
use Orchestra\Support\Str;

class AclController extends BaseController {

	/**
	 * Define the filters.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		$this->beforeFilter('orchestra.manage:acl');
	}

	/**
	 * Get default resources landing page.
	 *
	 * @access public
	 * @return Response
	 */
	public function getIndex()
	{
		$lists    = array();
		$selected = Input::get('name', 'orchestra');
		$acls     = Acl::all();
		$active   = null;
		$memory   = App::memory();

		foreach ($acls as $name => $instance)
		{
			$extension    = $memory->get("extensions.available.{$name}.name", null);
			$lists[$name] = (is_null($extension) ? Str::title($name) : $extension);

			if ($name === $selected) $active = $instance;
		}

		if (is_null($active)) return App::abort(404);

		$data     = array(
			'eloquent' => $active,
			'lists'    => $lists,
			'selected' => $selected,
		);

		Site::set('title', trans('orchestra/control::title.acls.list'));

		return View::make('orchestra/control::acl.index', $data);
	}

	/**
	 * Update ACL metric
	 *
	 * @access public
	 * @return Response
	 */
	public function postIndex()
	{
		$metric    = Input::get('metric');
		$instances = Acl::all();
		         
		if (is_null($metric) or ! isset($instances[$metric])) return App::abort(404);

		$acl = $instances[$metric];

		foreach ($acl->roles()->get() as $roleKey => $roleName)
		{
			foreach($acl->actions()->get() as $actionKey => $actionName)
			{
				$input = ('yes' === Input::get("acl-{$roleKey}-{$actionKey}", 'no'));

				$acl->allow($roleName, $actionName, $input);
			}
		}

		$admin = Role::admin();
		$acl->allow($admin->name, array('Manage Users', 'Manage Orchestra', 'Manage Roles', 'Manage Acl'));

		Messages::add('success', trans('orchestra/control::response.acls.update'));

		return Redirect::to(handles("orchestra/foundation::resources/control.acl?name={$metric}"));
	}

	/**
	 * Get sync roles action.
	 *
	 * @access public
	 * @param  string   $name
	 * @return Response
	 */
	public function getSync($name)
	{
		$roles = array();
		$acls  = Acl::all();

		if ( ! isset($acls[$name])) return App::abort(404);

		$current = $acls[$name];

		foreach (Role::all() as $role) $roles[] = $role->name;

		$current->roles()->fill($roles);
		
		Messages::add('success', trans('orchestra/control::response.acls.sync-roles', array(
			'name' => Str::humanize($name),
		)));

		return Redirect::to(handles("orchestra/foundation::resources/control.acl?name={$name}"));
	}
}
