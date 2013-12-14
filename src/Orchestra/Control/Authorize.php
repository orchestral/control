<?php namespace Orchestra\Control;

use Orchestra\Support\Facades\App;

class Authorize
{
    /**
     * Re-sync administrator access control.
     *
     * @return void
     */
    public static function sync()
    {
        $acl   = App::acl();
        $admin = App::make('orchestra.role')->admin();

        $acl->allow($admin->name, array('Manage Users', 'Manage Orchestra', 'Manage Roles', 'Manage Acl'));
    }
}
