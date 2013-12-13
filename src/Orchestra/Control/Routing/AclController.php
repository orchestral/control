<?php namespace Orchestra\Control\Routing;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\App;
use Orchestra\Support\Facades\Acl;
use Orchestra\Support\Facades\Messages;
use Orchestra\Support\Facades\Site;
use Orchestra\Control\Authorize;
use Orchestra\Model\Role;
use Orchestra\Support\Str;

class AclController extends BaseController
{
    /**
     * Memory instance.
     *
     * @var \Orchestra\Memory\Drivers\Driver
     */
    protected $memory;

    /**
     * Setup a new controller.
     */
    public function __construct()
    {
        $this->memory = App::memory();

        parent::__construct();
    }

    /**
     * Define the filters.
     *
     * @return void
     */
    protected function setupFilters()
    {
        $this->beforeFilter('control.manage:acl');
    }

    /**
     * Get default resources landing page.
     *
     * @return Response
     */
    public function getIndex()
    {
        $lists    = array();
        $selected = Input::get('name', 'orchestra');
        $acls     = Acl::all();
        $active   = null;

        foreach ($acls as $name => $instance) {
            $uid = str_replace('/', '.', $name);
            $lists[$uid] = $this->getExtensionName($name);

            if ($uid === $selected) {
                $active = $instance;
            }
        }

        if (is_null($active)) {
            return App::abort(404);
        }

        $data     = array(
            'eloquent' => $active,
            'lists'    => $lists,
            'selected' => $selected,
        );

        Site::set('title', trans('orchestra/control::title.acls.list'));

        return View::make('orchestra/control::acl.index', $data);
    }

    /**
     * Update ACL metric.
     *
     * @return Response
     */
    public function postIndex()
    {
        $metric    = Input::get('metric');
        $name      = str_replace('.', '/', $metric);
        $instances = Acl::all();

        if (is_null($name) or ! isset($instances[$name])) {
            return App::abort(404);
        }

        $acl = $instances[$name];

        foreach ($acl->roles()->get() as $roleKey => $roleName) {
            foreach ($acl->actions()->get() as $actionKey => $actionName) {
                $input = ('yes' === Input::get("acl-{$roleKey}-{$actionKey}", 'no'));

                $acl->allow($roleName, $actionName, $input);
            }
        }

        Authorize::sync();

        Messages::add('success', trans('orchestra/control::response.acls.update'));

        return Redirect::to(resources("control.acl?name={$metric}"));
    }

    /**
     * Get sync roles action.
     *
     * @param  string   $name
     * @return Response
     */
    public function getSync($uid)
    {
        $name  = str_replace('.', '/', $uid);
        $roles = array();
        $acls  = Acl::all();

        if (! isset($acls[$name])) {
            return App::abort(404);
        }

        $current = $acls[$name];

        foreach (Role::all() as $role) {
            $roles[] = $role->name;
        }

        $current->roles()->fill($roles);

        Messages::add('success', trans('orchestra/control::response.acls.sync-roles', array(
            'name' => $this->getExtensionName($name),
        )));

        return Redirect::to(resources("control.acl?name={$uid}"));
    }

    /**
     * Get extension name if possible.
     *
     * @param  string   $name
     * @return string
     */
    protected function getExtensionName($name)
    {
        $extension = $this->memory->get("extensions.available.{$name}.name", null);

        $name !== 'orchestra' or $extension = 'Orchestra Platform';

        return (is_null($extension) ? Str::title($name) : $extension);
    }
}
