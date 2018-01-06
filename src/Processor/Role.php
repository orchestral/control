<?php

namespace Orchestra\Control\Processor;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Orchestra\Model\Role as Eloquent;
use Orchestra\Contracts\Foundation\Foundation;
use Orchestra\Control\Validation\Role as RoleValidator;
use Orchestra\Control\Http\Presenters\Role as RolePresenter;

class Role extends Processor
{
    /**
     * Setup a new processor instance.
     *
     * @param  \Orchestra\Control\Http\Presenters\Role  $presenter
     * @param  \Orchestra\Control\Validation\Role  $validator
     * @param  \Orchestra\Contracts\Foundation\Foundation  $foundation
     */
    public function __construct(RolePresenter $presenter, RoleValidator $validator, Foundation $foundation)
    {
        $this->presenter  = $presenter;
        $this->validator  = $validator;
        $this->foundation = $foundation;
        $this->model      = $foundation->make('orchestra.role');
    }

    /**
     * View list roles page.
     *
     * @param  object  $listener
     *
     * @return mixed
     */
    public function index($listener)
    {
        $eloquent = $this->model->newQuery();
        $table    = $this->presenter->table($eloquent);

        $this->fireEvent('list', [$eloquent, $table]);

        // Once all event listening to `orchestra.list: role` is executed,
        // we can add we can now add the final column, edit and delete
        // action for roles.
        $this->presenter->actions($table);

        return $listener->indexSucceed(compact('eloquent', 'table'));
    }

    /**
     * View create a role page.
     *
     * @param  object  $listener
     *
     * @return mixed
     */
    public function create($listener)
    {
        $eloquent = $this->model;
        $form     = $this->presenter->form($eloquent);

        $this->fireEvent('form', [$eloquent, $form]);

        return $listener->createSucceed(compact('eloquent', 'form'));
    }

    /**
     * View edit a role page.
     *
     * @param  object  $listener
     * @param  string|int  $id
     *
     * @return mixed
     */
    public function edit($listener, $id)
    {
        $eloquent = $this->model->findOrFail($id);
        $form     = $this->presenter->form($eloquent);

        $this->fireEvent('form', [$eloquent, $form]);

        return $listener->editSucceed(compact('eloquent', 'form'));
    }

    /**
     * Store a role.
     *
     * @param  object  $listener
     * @param  array   $input
     *
     * @return mixed
     */
    public function store($listener, array $input)
    {
        $validation = $this->validator->on('create')->with($input);

        if ($validation->fails()) {
            return $listener->storeValidationFailed($validation);
        }

        $role = $this->model;

        try {
            $this->saving($role, $input, 'create');
        } catch (Exception $e) {
            return $listener->storeFailed(['error' => $e->getMessage()]);
        }

        return $listener->storeSucceed($role);
    }

    /**
     * Update a role.
     *
     * @param  object  $listener
     * @param  array   $input
     * @param  int     $id
     *
     * @return mixed
     */
    public function update($listener, array $input, $id)
    {
        if ((int) $id !== (int) $input['id']) {
            return $listener->userVerificationFailed();
        }

        $validation = $this->validator->on('update')->bind(['roleID' => $id])->with($input);

        if ($validation->fails()) {
            return $listener->updateValidationFailed($validation, $id);
        }

        $role = $this->model->findOrFail($id);

        try {
            $this->saving($role, $input, 'update');
        } catch (Exception $e) {
            return $listener->updateFailed(['error' => $e->getMessage()]);
        }

        return $listener->updateSucceed($role);
    }

    /**
     * Delete a role.
     *
     * @param  object  $listener
     * @param  string|int  $id
     *
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
            return $listener->destroyFailed(['error' => $e->getMessage()]);
        }

        return $listener->destroySucceed($role);
    }

    /**
     * Save the role.
     *
     * @param  \Orchestra\Model\Role  $role
     * @param  array  $input
     * @param  string  $type
     *
     * @return bool
     */
    protected function saving(Eloquent $role, $input = [], $type = 'create')
    {
        $beforeEvent = ($type === 'create' ? 'creating' : 'updating');
        $afterEvent  = ($type === 'create' ? 'created' : 'updated');

        $role->setAttribute('name', $input['name']);

        $this->fireEvent($beforeEvent, [$role]);
        $this->fireEvent('saving', [$role]);

        DB::transaction(function () use ($role) {
            $role->save();
        });

        $this->fireEvent($afterEvent, [$role]);
        $this->fireEvent('saved', [$role]);

        return true;
    }

    /**
     * Fire Event related to eloquent process.
     *
     * @param  string  $type
     * @param  array   $parameters
     *
     * @return void
     */
    protected function fireEvent($type, array $parameters = [])
    {
        Event::dispatch("orchestra.control.{$type}: roles", $parameters);
    }
}
