<?php namespace Orchestra\Control;

use Orchestra\Foundation\Support\MenuHandler;
use Orchestra\Contracts\Authorization\Authorization;

class ControlMenuHandler extends MenuHandler
{
    /**
     * Get ID.
     *
     * @return string
     */
    protected function getId()
    {
        return 'control';
    }

    /**
     * Get position.
     *
     * @return string
     */
    protected function getPosition()
    {
        return $this->menu->has('extensions') ? '^:extensions' : '>:home';
    }

    /**
     * Get the URL.
     *
     * @return string
     */
    protected function getLink()
    {
        return handles('orchestra::control');
    }

    /**
     * Get the title.
     *
     * @return string
     */
    protected function getTitle()
    {
        return 'Control';
    }

    /**
     * Check whether the menu should be displayed.
     *
     * @param  \Orchestra\Contracts\Authorization\Authorization  $acl
     * @return bool
     */
    public function authorize(Authorization $acl)
    {
        return ($acl->can('manage roles') || $acl->can('manage acl'));
    }
}
