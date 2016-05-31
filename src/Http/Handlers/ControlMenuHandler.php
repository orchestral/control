<?php

namespace Orchestra\Control\Http\Handlers;

use Orchestra\Foundation\Support\MenuHandler;
use Orchestra\Contracts\Authorization\Authorization;

class ControlMenuHandler extends MenuHandler
{
    /**
     * Menu configuration.
     *
     * @var array
     */
    protected $menu = [
        'id'       => 'control',
        'title'    => 'Control',
        'link'     => '#!',
        'icon'     => 'puzzle-piece',
        'with'     => [
            RoleMenuHandler::class,
        ],
    ];

    /**
     * Get position.
     *
     * @return string
     */
    public function getPositionAttribute()
    {
        return $this->handler->has('extensions') ? '>:extensions' : '>:home';
    }

    /**
     * Check whether the menu should be displayed.
     *
     * @param  \Orchestra\Contracts\Authorization\Authorization  $acl
     *
     * @return bool
     */
    public function authorize(Authorization $acl)
    {
        return ($acl->canIf('manage roles') || $acl->canIf('manage acl'));
    }
}
