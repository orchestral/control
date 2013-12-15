<?php namespace Orchestra\Control\Processor;

use Exception;
use Illuminate\Support\Facades\DB;
use Orchestra\Control\Presenter\Role as RolePresenter;
use Orchestra\Control\Validation\Role as RoleValidator;
use Orchestra\Support\Facades\App;

class Role extends AbstractableProcessor
{
    /**
     * Setup a new processor instance.
     *
     * @param  \Orchestra\Control\Presenter\Role   $presenter
     * @param  \Orchestra\Control\Validation\Role  $validator
     */
    public function __construct(RolePresenter $presenter, RoleValidator $validator)
    {
        $this->presenter = $presenter;
        $this->validator = $validator;
        $this->model     = App::make('orchestra.role');
    }

    /**
     * View list roles page.
     *
     * @param  object  $listener
     * @return mixed
     */
    public function index($listener)
    {
        $eloquent = $this->model->paginate();
        $table    = $this->presenter->table($eloquent);

        return $listener->indexSucceed(compact('eloquent', 'table'));
    }

    /**
     * View create a role page.
     *
     * @param  object  $listener
     * @return mixed
     */
    public function create($listener)
    {
        $eloquent = $this->model;
        $form     = $this->presenter->form($eloquent);

        return $listener->createSucceed(compact('eloquent', 'form'));
    }

    /**
     * View edit a role page.
     *
     * @param  object          $listener
     * @param  string|integer  $id
     * @return mixed
     */
    public function edit($listener, $id)
    {
        $eloquent = $this->model->findOrFail($id);
        $form     = $this->presenter->form($eloquent);

        return $listener->editSucceed(compact('eloquent', 'form'));
    }

    /**
     * Store a role.
     *
     * @param  object  $listener
     * @param  array   $input
     * @return mixed
     */
    public function store($listener, array $input)
    {
        $validation = $this->validator->on('create')->with($input);

        if ($validation->fails()) {
            return $listener->storeValidationFailed($validation);
        }

        $role       = $this->model;
        $role->name = $input['name'];

        try {
            DB::transaction(function () use ($role) {
                $role->save();
            });
        } catch (Exception $e) {
            return $listener->storeFailed(array('error' => $e->getMessage()));
        }

        return $listener->storeSucceed($role);
    }

    /**
     * Update a role.
     *
     * @param  object  $listener
     * @param  array   $input
     * @param  integer $id
     * @return mixed
     */
    public function update($listener, array $input, $id)
    {
        if ((int) $id !== (int) $input['id']) {
            return $listener->userVerificationFailed();
        }

        $validation = $this->validator->on('update')->bind(array('roleID' => $id))->with($input);

        if ($validation->fails()) {
            return $listener->updateValidationFailed($validation, $id);
        }

        $role = $this->model->findOrFail($id);
        $role->name = $input['name'];

        try {
            DB::transaction(function () use ($role) {
                $role->save();
            });
        } catch (Exception $e) {
            return $listener->updateFailed(array('error' => $e->getMessage()));
        }

        return $listener->updateSucceed($role);
    }

    /**
     * Delete a role.
     *
     * @param  object          $listener
     * @param  string|integer  $id
     * @return mixed
     */
    public function destroy($listener, $id)
    {
        $role = $this->model->findOrFail($id);

        try {
            DB::transaction(function () use ($role) {
                $role->delete();
            });
        } catch (Exception $e) {
            return $listener->destroyFailed(array('error' => $e->getMessage()));
        }

        return $listener->destroySucceed($role);
    }
}
