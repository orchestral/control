<?php

namespace Orchestra\Control\Http\Handlers;

use Orchestra\Contracts\Authorization\Authorization;
use Orchestra\Foundation\Support\MenuHandler;

class RoleMenuHandler extends MenuHandler
{
    /**
     * Menu configuration.
     *
     * @var array
     */
    protected $menu = [
        'id' => 'control-roles',
        'title' => 'Roles',
        'link' => 'orchestra::control/roles',
        'icon' => null,
    ];

    /**
     * Check whether the menu should be displayed.
     *
     * @param  \Orchestra\Contracts\Authorization\Authorization  $acl
     *
     * @return bool
     */
    public function authorize(Authorization $acl)
    {
        return $acl->canIf('manage roles');
    }
}
