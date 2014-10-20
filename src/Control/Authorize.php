<?php namespace Orchestra\Control;

use Orchestra\Support\Facades\Foundation;

class Authorize
{
    /**
     * Re-sync administrator access control.
     *
     * @return void
     */
    public static function sync()
    {
        $acl   = Foundation::acl();
        $admin = Foundation::make('orchestra.role')->admin();

        $acl->allow($admin->name, ['Manage Users', 'Manage Orchestra', 'Manage Roles', 'Manage Acl']);
    }
}
