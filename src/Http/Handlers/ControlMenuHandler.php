<?php

namespace Orchestra\Control\Http\Handlers;

use Orchestra\Foundation\Support\MenuHandler;

class ControlMenuHandler extends MenuHandler
{
    /**
     * Menu configuration.
     *
     * @var array
     */
    protected $menu = [
        'id'    => 'control',
        'title' => 'Control',
        'link'  => '#!',
        'icon'  => 'puzzle-piece',
        'with'  => [
            RoleMenuHandler::class,
            AclMenuHandler::class,
            ThemeMenuHandler::class,
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
     * @return bool
     */
    public function authorize()
    {
        return $this->hasNestedMenu();
    }
}
