<?php namespace Orchestra\Control\Routing;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Orchestra\Control\Processor\Role as RoleProcessor;
use Orchestra\Model\Role;
use Orchestra\Support\Facades\Site;

class RolesController extends BaseController
{
    /**
     * Setup a new controller.
     *
     * @param  \Orchestra\Control\Processor\Role    $role
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
        $this->beforeFilter('control.manage:roles');
    }

    /**
     * List all the roles
     *
     * @return Response
     */
    public function index()
    {
        return $this->processor->index($this);
    }

    /**
     * Show a role.
     *
     * @return Response
     */
    public function show($id)
    {
        return $this->edit($id);
    }

    /**
     * Create a new role.
     *
     * @return Response
     */
    public function create()
    {
        return $this->processor->create($this);
    }

    /**
     * Edit the role.
     *
     * @return Response
     */
    public function edit($id)
    {
        return $this->processor->edit($this, $id);
    }

    /**
     * Create the role.
     *
     * @return Response
     */
    public function store()
    {
        return $this->processor->store($this, Input::all());
    }

    /**
     * Update the role.
     *
     * @param  integer  $id
     * @return Response
     */
    public function update($id)
    {
        return $this->processor->update($this, Input::all(), $id);
    }

    /**
     * Request to delete a role.
     *
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
     * @param  integer  $id
     * @return Response
     */
    public function destroy($id)
    {
        return $this->processor->destroy($this, $id);
    }

    /**
     * Response when list roles page succeed.
     *
     * @param  array  $data
     * @return Response
     */
    public function indexSucceed(array $data)
    {
        Site::set('title', trans('orchestra/control::title.roles.list'));

        return View::make('orchestra/control::roles.index', $data);
    }

    /**
     * Response when create role page succeed.
     *
     * @param  array  $data
     * @return Response
     */
    public function createSucceed(array $data)
    {
        Site::set('title', trans('orchestra/control::title.roles.create'));

        return View::make('orchestra/control::roles.edit', $data);
    }

    /**
     * Response when edit role page succeed.
     *
     * @param  array  $data
     * @return Response
     */
    public function editSucceed(array $data)
    {
        Site::set('title', trans('orchestra/control::title.roles.update'));

        return View::make('orchestra/control::roles.edit', $data);
    }

     /**
     * Response when storing role failed on validation.
     *
     * @param  object  $validation
     * @return Response
     */
    public function storeValidationFailed($validation)
    {
        return $this->redirectWithErrors(resources('control.roles/create'), $validation);
    }

    /**
     * Response when storing role failed.
     *
     * @param  array    $error
     * @return Response
     */
    public function storeFailed(array $error)
    {
        $message = trans('orchestra/foundation::response.db-failed', $error);

        return $this->redirectWithMessage(resources('control.roles'), $message);
    }

    /**
     * Response when storing user succeed.
     *
     * @param  \Orchestra\Model\Role   $role
     * @return Response
     */
    public function storeSucceed(Role $role)
    {
        $message = trans('orchestra/control::response.roles.create', array('name' => $role->name));

        return $this->redirectWithMessage(resources('control.roles'), $message);
    }


    /**
     * Response when updating role failed on validation.
     *
     * @param  object  $validation
     * @param  integer $id
     * @return Response
     */
    public function updateValidationFailed($validation, $id)
    {
        return $this->redirectWithErrors(resources("control.roles/{$id}/edit"), $validation);
    }

    /**
     * Response when updating role failed.
     *
     * @param  array   $error
     * @return Response
     */
    public function updateFailed(array $error)
    {
        $message = trans('orchestra/foundation::response.db-failed', $error);

        return $this->redirectWithMessage(resources('control.roles'), $message);
    }

    /**
     * Response when updating role succeed.
     *
     * @param  \Orchestra\Model\Role   $role
     * @return Response
     */
    public function updateSucceed(Role $role)
    {
        $message = trans('orchestra/control::response.roles.update', array('name' => $role->name));

        return $this->redirectWithMessage(resources('control.roles'), $message);
    }

    /**
     * Response when deleting role failed.
     *
     * @param  array   $error
     * @return Response
     */
    public function destroyFailed(array $error)
    {
        $message = trans('orchestra/foundation::response.db-failed', $error);

        return $this->redirectWithMessage(resources('control.roles'), $message);
    }

    /**
     * Response when updating role succeed.
     *
     * @param  \Orchestra\Model\Role   $role
     * @return Response
     */
    public function destroySucceed(Role $role)
    {
        $message = trans('orchestra/control::response.roles.delete', array('name' => $role->name));

        return $this->redirectWithMessage(resources('control.roles'), $message);
    }

    /**
     * Response when user verification failed.
     *
     * @return Response
     */
    public function userVerificationFailed()
    {
        return $this->suspend(500);
    }
}
