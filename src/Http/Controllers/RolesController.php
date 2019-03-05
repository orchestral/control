<?php

namespace Orchestra\Control\Http\Controllers;

use Orchestra\Model\Role;
use Illuminate\Support\Facades\Input;
use Orchestra\Control\Processors\Role as RoleProcessor;
use Orchestra\Foundation\Http\Controllers\AdminController;

class RolesController extends AdminController
{
    /**
     * Define the middleware.
     *
     * @return void
     */
    protected function onCreate()
    {
        $this->middleware('orchestra.can:manage-roles');
        $this->middleware('orchestra.csrf', ['only' => 'delete']);
    }

    /**
     * List all the roles.
     *
     * @param  \Orchestra\Control\Processors\Role   $processor
     *
     * @return mixed
     */
    public function index(RoleProcessor $processor)
    {
        return $processor->index($this);
    }

    /**
     * Show a role.
     *
     * @param  \Orchestra\Control\Processors\Role   $processor
     * @param  int  $roles
     *
     * @return mixed
     */
    public function show(RoleProcessor $processor, $roles)
    {
        return $this->edit($processor, $roles);
    }

    /**
     * Create a new role.
     *
     * @param  \Orchestra\Control\Processors\Role   $processor
     *
     * @return mixed
     */
    public function create(RoleProcessor $processor)
    {
        return $processor->create($this);
    }

    /**
     * Edit the role.
     *
     * @param  \Orchestra\Control\Processors\Role   $processor
     * @param  int  $roles
     *
     * @return mixed
     */
    public function edit(RoleProcessor $processor, $roles)
    {
        return $processor->edit($this, $roles);
    }

    /**
     * Create the role.
     *
     * @param  \Orchestra\Control\Processors\Role   $processor
     *
     * @return mixed
     */
    public function store(RoleProcessor $processor)
    {
        return $processor->store($this, Input::all());
    }

    /**
     * Update the role.
     *
     * @param  \Orchestra\Control\Processors\Role   $processor
     * @param  int  $roles
     *
     * @return mixed
     */
    public function update(RoleProcessor $processor, $roles)
    {
        return $processor->update($this, Input::all(), $roles);
    }

    /**
     * Request to delete a role.
     *
     * @param  \Orchestra\Control\Processors\Role   $processor
     * @param  int  $roles
     *
     * @return mixed
     */
    public function delete(RoleProcessor $processor, $roles)
    {
        return $this->destroy($processor, $roles);
    }

    /**
     * Request to delete a role.
     *
     * @param  \Orchestra\Control\Processors\Role   $processor
     * @param  int  $roles
     *
     * @return mixed
     */
    public function destroy(RoleProcessor $processor, $roles)
    {
        return $processor->destroy($this, $roles);
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
        \set_meta('title', \trans('orchestra/control::title.roles.list'));

        return \view('orchestra/control::roles.index', $data);
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
        \set_meta('title', \trans('orchestra/control::title.roles.create'));

        return \view('orchestra/control::roles.edit', $data);
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
        \set_meta('title', \trans('orchestra/control::title.roles.update'));

        return \view('orchestra/control::roles.edit', $data);
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
        return $this->redirectWithErrors(
            \handles('orchestra::control/roles/create'), $validation
        );
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
        $message = \trans('orchestra/foundation::response.db-failed', $error);

        return $this->redirectWithMessage(
            \handles('orchestra::control/roles'), $message, 'error'
        );
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
        $message = \trans('orchestra/control::response.roles.create', [
            'name' => $role->getAttribute('name'),
        ]);

        return $this->redirectWithMessage(
            \handles('orchestra::control/roles'), $message
        );
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
        return $this->redirectWithErrors(
            \handles("orchestra::control/roles/{$id}/edit"), $validation
        );
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
        $message = \trans('orchestra/foundation::response.db-failed', $errors);

        return $this->redirectWithMessage(
            \handles('orchestra::control/roles'), $message
        );
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
        $message = \trans('orchestra/control::response.roles.update', [
            'name' => $role->getAttribute('name'),
        ]);

        return $this->redirectWithMessage(
            \handles('orchestra::control/roles'), $message
        );
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
        $message = \trans('orchestra/foundation::response.db-failed', $error);

        return $this->redirectWithMessage(
            \handles('orchestra::control/roles'), $message
        );
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
        $message = \trans('orchestra/control::response.roles.delete', [
            'name' => $role->getAttribute('name'),
        ]);

        return $this->redirectWithMessage(
            \handles('orchestra::control/roles'), $message
        );
    }

    /**
     * Response when user verification failed.
     *
     * @return mixed
     */
    public function userVerificationFailed()
    {
        return \abort(500);
    }
}
