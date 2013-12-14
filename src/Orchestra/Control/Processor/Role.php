<?php namespace Orchestra\Control\Processor;

use Exception;
use Illuminate\Support\Facades\DB;
use Orchestra\Control\Presenter\Role as RolePresenter;
use Orchestra\Control\Validation\Role as RoleValidator;
use Orchestra\Model\Role as Eloquent;

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
    }

    public function index($listener)
    {
        $eloquent = Eloquent::paginate();
        $table    = $this->presenter->table($eloquent);

        return $listener->indexSucceed(compact('eloquent', 'table'));
    }

    public function create($listener)
    {
        $eloquent = new Eloquent;
        $form     = $this->prsenter->form($eloquent, 'create');

        return $listener->createSucceed(compact('eloquent', 'form'));
    }

    public function edit($listener, $id)
    {
        $eloquent = Eloquent::findOrFail($id);
        $form     = $this->presenter->form($eloquent, 'update');

        return $listener->updateSucceed(compact('eloquent', 'form'));
    }

    public function store($listener, array $input)
    {
        $validation = $this->validator->on('create')->with($input);

        if ($validation->fails()) {
            return $listener->storeValidationFailed($validation);
        }

        $role = new Eloquent;
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

    public function update($listener, array $input)
    {
        // Check if provided id is the same as hidden id, just a pre-caution.
        if ((int) $id !== (int) $input['id']) {
            return $listener->userVerificationFailed();
        }

        $validation = $this->validator->on('update')->bind(array('roleID' => $id))->with($input);

        if ($validation->fails()) {
            return $listener->updateValidationFailed($validation, $id);
        }

        $role = Eloquent::findOrFail($id);
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

    public function destroy($listener, $id)
    {
        $role = Eloquent::findOrFail($id);

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
