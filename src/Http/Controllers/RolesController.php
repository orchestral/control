<?php namespace Orchestra\Control\Http\Controllers;

use Orchestra\Model\Role;
use Illuminate\Support\Facades\Input;
use Orchestra\Control\Processor\Role as RoleProcessor;
use Orchestra\Foundation\Http\Controllers\AdminController;

class RolesController extends AdminController
{
    /**
     * Setup a new controller.
     *
     * @param  \Orchestra\Control\Processor\Role   $processor
     */
    public function __construct(RoleProcessor $processor)
    {
        $this->processor = $processor;

        parent::__construct();
    }

    /**
     * Define the filters.
     *
     * @return void
     */
    protected function setupFilters()
    {
        $this->middleware('control.manage:roles');
        $this->middleware('control.csrf', ['only' => 'delete']);
    }

    /**
     * List all the roles.
     *
     * @return mixed
     */
    public function index()
    {
        return $this->processor->index($this);
    }

    /**
     * Show a role.
     *
     * @param  int  $roles
     *
     * @return mixed
     */
    public function show($roles)
    {
        return $this->edit($roles);
    }

    /**
     * Create a new role.
     *
     * @return mixed
     */
    public function create()
    {
        return $this->processor->create($this);
    }

    /**
     * Edit the role.
     *
     * @param  int  $roles
     *
     * @return mixed
     */
    public function edit($roles)
    {
        return $this->processor->edit($this, $roles);
    }

    /**
     * Create the role.
     *
     * @return mixed
     */
    public function store()
    {
        return $this->processor->store($this, Input::all());
    }

    /**
     * Update the role.
     *
     * @param  int  $roles
     *
     * @return mixed
     */
    public function update($roles)
    {
        return $this->processor->update($this, Input::all(), $roles);
    }

    /**
     * Request to delete a role.
     *
     * @param  int  $roles
     *
     * @return mixed
     */
    public function delete($roles)
    {
        return $this->destroy($roles);
    }

    /**
     * Request to delete a role.
     *
     * @param  int  $roles
     *
     * @return mixed
     */
    public function destroy($roles)
    {
        return $this->processor->destroy($this, $roles);
    }

    /**
     * Response when list roles page succeed.
     *
     * @param  array  $data
     *
     * @return mixed
     */
    public function indexSucceed(array $data)
    {
        set_meta('title', trans('orchestra/control::title.roles.list'));

        return view('orchestra/control::roles.index', $data);
    }

    /**
     * Response when create role page succeed.
     *
     * @param  array  $data
     *
     * @return mixed
     */
    public function createSucceed(array $data)
    {
        set_meta('title', trans('orchestra/control::title.roles.create'));

        return view('orchestra/control::roles.edit', $data);
    }

    /**
     * Response when edit role page succeed.
     *
     * @param  array  $data
     *
     * @return mixed
     */
    public function editSucceed(array $data)
    {
        set_meta('title', trans('orchestra/control::title.roles.update'));

        return view('orchestra/control::roles.edit', $data);
    }

    /**
     * Response when storing role failed on validation.
     *
     * @param  object  $validation
     *
     * @return mixed
     */
    public function storeValidationFailed($validation)
    {
        return $this->redirectWithErrors(handles('orchestra::control/roles/create'), $validation);
    }

    /**
     * Response when storing role failed.
     *
     * @param  array  $error
     *
     * @return mixed
     */
    public function storeFailed(array $error)
    {
        $message = trans('orchestra/foundation::response.db-failed', $error);

        return $this->redirectWithMessage(handles('orchestra::control/roles'), $message);
    }

    /**
     * Response when storing user succeed.
     *
     * @param  \Orchestra\Model\Role  $role
     *
     * @return mixed
     */
    public function storeSucceed(Role $role)
    {
        $message = trans('orchestra/control::response.roles.create', [
            'name' => $role->getAttribute('name')
        ]);

        return $this->redirectWithMessage(handles('orchestra::control/roles'), $message);
    }

    /**
     * Response when updating role failed on validation.
     *
     * @param  object  $validation
     * @param  int     $id
     *
     * @return mixed
     */
    public function updateValidationFailed($validation, $id)
    {
        return $this->redirectWithErrors(handles("orchestra::control/roles/{$id}/edit"), $validation);
    }

    /**
     * Response when updating role failed.
     *
     * @param  array  $errors
     *
     * @return mixed
     */
    public function updateFailed(array $errors)
    {
        $message = trans('orchestra/foundation::response.db-failed', $errors);

        return $this->redirectWithMessage(handles('orchestra::control/roles'), $message);
    }

    /**
     * Response when updating role succeed.
     *
     * @param  \Orchestra\Model\Role  $role
     *
     * @return mixed
     */
    public function updateSucceed(Role $role)
    {
        $message = trans('orchestra/control::response.roles.update', [
            'name' => $role->getAttribute('name')
        ]);

        return $this->redirectWithMessage(handles('orchestra::control/roles'), $message);
    }

    /**
     * Response when deleting role failed.
     *
     * @param  array  $error
     *
     * @return mixed
     */
    public function destroyFailed(array $error)
    {
        $message = trans('orchestra/foundation::response.db-failed', $error);

        return $this->redirectWithMessage(handles('orchestra::control/roles'), $message);
    }

    /**
     * Response when updating role succeed.
     *
     * @param  \Orchestra\Model\Role  $role
     *
     * @return mixed
     */
    public function destroySucceed(Role $role)
    {
        $message = trans('orchestra/control::response.roles.delete', [
            'name' => $role->getAttribute('name')
        ]);

        return $this->redirectWithMessage(handles('orchestra::control/roles'), $message);
    }

    /**
     * Response when user verification failed.
     *
     * @return mixed
     */
    public function userVerificationFailed()
    {
        return $this->suspend(500);
    }
}
