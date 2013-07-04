<?php namespace Orchestra\Control\Routing;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Orchestra\Control\Services\RolePresenter;
use Orchestra\Support\Facades\App;
use Orchestra\Support\Facades\Messages;
use Orchestra\Support\Facades\Site;
use Orchestra\Model\Role;

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

	/**
	 * Show a role.
	 * 
	 * @access public
	 * @return Response
	 */
	public function show($id)
	{
		return $this->edit($id);
	}

	/**
	 * Create a new role.
	 *
	 * @access public
	 * @return Response
	 */
	public function create()
	{
		$role = new Role;
		$form = RolePresenter::form($role, 'create');

		Site::set('title', trans('orchestra/control::title.roles.create'));

		return View::make('orchestra/control::roles.edit', compact('role', 'form'));
	}

	/**
	 * Edit the role.
	 *
	 * @access public
	 * @return Response
	 */
	public function edit($id)
	{
		$role = Role::findOrFail($id);
		$form = RolePresenter::form($role, 'update');

		Site::set('title', trans('orchestra/control::title.roles.update'));

		return View::make('orchestra/control::roles.edit', compact('role', 'form'));
	}

	/**
	 * Create the role.
	 *
	 * @access public
	 * @return Response
	 */
	public function store() 
	{
		$input      = Input::all();
		$validation = App::make('Orchestra\Control\Services\RoleValidation')
						->on('create')->with($input);

		if ($validation->fails())
		{
			return Redirect::to(resources("control.roles/create"))
					->withInput()
					->withErrors($validation);
		}

		$role = new Role;
		$role->name = $input['name'];

		try
		{
			DB::transaction(function () use ($role)
			{
				$role->save();
			});

			Messages::add('success', trans('orchestra/control::response.roles.create', array(
				'name' => $role->name,
			)));
		}
		catch (Exception $e)
		{
			Messages::add('error', trans('orchestra/foundation::response.db-failed', array(
				'error' => $e->getMessage(),
			)));
		}

		return Redirect::to(resources("control.roles"));
	}

	/**
	 * Update the role.
	 *
	 * @access public
	 * @param  integer  $id
	 * @return Response
	 */
	public function update($id) 
	{
		$input = Input::all();

		// Check if provided id is the same as hidden id, just a pre-caution.
		if ((int) $id !== (int) $input['id']) return App::abort(500);

		$validation = App::make('Orchestra\Control\Services\RoleValidation')
						->on('update')->bind(array('roleID' => $id))->with($input);

		if ($validation->fails())
		{
			return Redirect::to(resources("control.roles/{$id}/edit"))
					->withInput()
					->withErrors($validation);
		}

		$role = Role::findOrFail($id);
		$role->name = $input['name'];

		try
		{
			DB::transaction(function () use ($role)
			{
				$role->save();
			});

			Messages::add('success', trans('orchestra/control::response.roles.update', array(
				'name' => $role->name,
			)));
		}
		catch (Exception $e)
		{
			Messages::add('error', trans('orchestra/foundation::response.db-failed', array(
				'error' => $e->getMessage(),
			)));
		}

		return Redirect::to(resources("control.roles"));
	}

	/**
	 * Request to delete a role.
	 * 
	 * @access public
	 * @param  integer  $id 
	 * @return Response
	 */
	public function delete($id)
	{
		return $this->destroy($id);
	}

	/**
	 * Request to delete a role.
	 * 
	 * @access public
	 * @param  integer  $id 
	 * @return Response
	 */
	public function destroy($id)
	{
		$role = Role::findOrFail($id);

		try
		{
			DB::transaction(function () use ($role)
			{				
				$role->delete();
			});

			Messages::add('success', trans('orchestra/control::response.roles.delete', array(
				'name' => $role->name,
			)));
		}
		catch (Exception $e)
		{
			Messages::add('error', trans('orchestra/foundation::response.db-failed', array(
				'error' => $e->getMessage(),
			)));
		}

		return Redirect::to(resources("control.roles"));
	}
}
