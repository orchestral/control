<?php namespace Orchestra\Control\Processor;

use Illuminate\Support\Fluent;
use Orchestra\Support\Facades\App;
use Orchestra\Support\Str;

class Acl extends AbstractableProcessor
{
    /**
     * ACL instance.
     *
     * @var \Orchestra\Auth\Acl\Environment
     */
    protected $acl;

    /**
     * Setup a new processor.
     */
    public function __construct()
    {
        $this->memory = App::memory();
        $this->acl    = App::make('orchestra.acl');
        $this->model  = App::make('orchestra.role');
    }

    /**
     * List ACL collection.
     *
     * @param  object  $listener
     * @param  string  $id
     * @return mixed
     */
    public function index($listener, $id)
    {
        $collection = array();
        $instances  = $this->acl->all();
        $eloquent   = null;

        foreach ($instances as $name => $instance) {
            $uid = $this->getUidFromName($name);
            $collection[$uid] = $this->getExtensionName($name);

            $uid === $id and $eloquent = $instance;
        }

        if (is_null($eloquent)) {
            return $listener->aclVerificationFailed();
        }

        return $listener->indexSucceed(compact('eloquent', 'collection', 'id'));
    }

    /**
     * Update ACL metric.
     *
     * @param  object  $listener
     * @param  array   $input
     * @return mixed
     */
    public function update($listener, array $input)
    {
        $uid  = $input['metric'];
        $name = $this->getNameFromUid($uid);

        $acl = $this->acl->get($name);

        if (is_null($acl)) {
            return $listener->aclVerificationFailed();
        }

        $roles   = $acl->roles()->get();
        $actions = $acl->actions()->get();

        foreach ($roles as $roleKey => $roleName) {
            foreach ($actions as $actionKey => $actionName) {
                $value = ('yes' === array_get($input, "acl-{$roleKey}-{$actionKey}", 'no'));

                $acl->allow($roleName, $actionName, $value);
            }
        }

        return $listener->updateSucceed($uid);
    }

    /**
     * Sync role for an ACL instance.
     *
     * @param  object  $listener
     * @param  string  $id
     * @return mixed
     */
    public function sync($listener, $id)
    {
        $roles = array();
        $name  = $this->getNameFromUid($id);
        $acl   = $this->acl->get($name);

        if (is_null($acl)) {
            return $listener->aclVerificationFailed();
        }

        foreach ($this->model->all() as $role) {
            $roles[] = $role->name;
        }

        $acl->roles()->attach($roles);

        return $listener->syncSucceed(new Fluent(compact('id', 'name')));
    }

    /**
     * Get ACL uid from name.
     *
     * @param  string  $name
     * @return string
     */
    protected function getUidFromName($name)
    {
        return str_replace('/', '.', $name);
    }

    /**
     * Get ACL name from uid.
     *
     * @param  string  $uid
     * @return string
     */
    protected function getNameFromUid($uid)
    {
        return str_replace('.', '/', $uid);
    }

    /**
     * Get extension name (if available).
     *
     * @param  string   $name
     * @return string
     */
    protected function getExtensionName($name)
    {
        $extension = $this->memory->get("extensions.available.{$name}.name");

        $name !== 'orchestra' or $extension = 'Orchestra Platform';

        return (is_null($extension) ? Str::title($name) : $extension);
    }
}
