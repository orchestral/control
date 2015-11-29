<?php namespace Orchestra\Control\Processor;

use Orchestra\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Fluent;
use Orchestra\Contracts\Authorization\Factory;
use Orchestra\Contracts\Foundation\Foundation;
use Orchestra\Contracts\Authorization\Authorization as AuthorizationContract;

class Authorization extends Processor
{
    /**
     * ACL instance.
     *
     * @var \Orchestra\Contracts\Authorization\Factory
     */
    protected $acl;

    /**
     * The translator implementation.
     *
     * @var \Illuminate\Tranlation\Translator
     */
    protected $translator;

    /**
     * Setup a new processor.
     *
     * @param  \Orchestra\Contracts\Foundation\Foundation  $foundation
     * @param  \Orchestra\Contracts\Authorization\Factory  $acl
     */
    public function __construct(Foundation $foundation, Factory $acl)
    {
        $this->foundation = $foundation;
        $this->memory     = $foundation->memory();
        $this->acl        = $acl;
        $this->model      = $foundation->make('orchestra.role');
        $this->translator = $foundation->make('translator');
    }

    /**
     * List ACL collection.
     *
     * @param  object  $listener
     * @param  string  $metric
     *
     * @return mixed
     */
    public function edit($listener, $metric)
    {
        $collection = [];
        $instances  = $this->acl->all();
        $eloquent   = null;

        foreach ($instances as $name => $instance) {
            $collection[$name] = $this->getAuthorizationName($name);

            $name === $metric && $eloquent = $instance;
        }

        if (is_null($eloquent)) {
            return $listener->aclVerificationFailed();
        }

        $actions = $this->getAuthorizationActions($eloquent, $metric);
        $roles   = $this->getAuthorizationRoles($eloquent);

        return $listener->indexSucceed(compact('actions', 'roles', 'eloquent', 'collection', 'metric'));
    }

    /**
     * Update ACL metric.
     *
     * @param  object  $listener
     * @param  array   $input
     *
     * @return mixed
     */
    public function update($listener, array $input)
    {
        $metric = $input['metric'];
        $acl    = $this->acl->get($metric);

        if (is_null($acl)) {
            return $listener->aclVerificationFailed();
        }

        $roles   = $acl->roles()->get();
        $actions = $acl->actions()->get();

        foreach ($roles as $roleKey => $roleName) {
            foreach ($actions as $actionKey => $actionName) {
                $value = ('yes' === Arr::get($input, "acl-{$roleKey}-{$actionKey}", 'no'));

                $acl->allow($roleName, $actionName, $value);
            }
        }

        return $listener->updateSucceed($metric);
    }

    /**
     * Sync role for an ACL instance.
     *
     * @param  object  $listener
     * @param  string  $vendor
     * @param  string|null  $package
     *
     * @return mixed
     */
    public function sync($listener, $vendor, $package = null)
    {
        $roles = [];
        $name  = $this->getExtension($vendor, $package)->get('name');
        $acl   = $this->acl->get($name);

        if (is_null($acl)) {
            return $listener->aclVerificationFailed();
        }

        foreach ($this->model->all() as $role) {
            $roles[] = $role->name;
        }

        $acl->roles()->attach($roles);

        $acl->sync();

        return $listener->syncSucceed(new Fluent(compact('vendor', 'package', 'name')));
    }

    /**
     * Get extension name (if available).
     *
     * @param  string  $name
     *
     * @return string
     */
    protected function getAuthorizationName($name)
    {
        $extension = $this->memory->get("extensions.available.{$name}.name");
        $title     = ($name === 'orchestra') ? 'Orchestra Platform' : $extension;

        return (is_null($title) ? Str::humanize($name) : $title);
    }

    /**
     * Get authorization actions.
     *
     * @param  \Orchestra\Contracts\Authorization\Authorization  $acl
     * @param  string  $metric
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getAuthorizationActions(AuthorizationContract $acl, $metric)
    {
        return collect($acl->actions()->get())->map(function ($slug) use ($metric) {
            $key = "orchestra/foundation::acl.{$metric}.{$slug}";
            $name = $this->translator->has($key) ? $this->translator->get($key) : Str::humanize($slug);

            return compact('slug', 'name');
        });
    }

    /**
     * Get authorization roles.
     *
     * @param  \Orchestra\Contracts\Authorization\Authorization  $acl
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getAuthorizationRoles(AuthorizationContract $acl)
    {
        return collect($acl->roles()->get())->reject(function ($role) {
            return in_array($role, ['guest']);
        })->map(function ($slug) {
            $name = Str::humanize($slug);

            return compact('slug', 'name');
        });
    }

    /**
     * Get extension information.
     *
     * @param  string  $vendor
     * @param  string|null  $package
     *
     * @return \Illuminate\Support\Fluent
     */
    protected function getExtension($vendor, $package = null)
    {
        $name = (is_null($package) ? $vendor : implode('/', [$vendor, $package]));

        return new Fluent(['name' => $name, 'uid' => $name]);
    }
}
