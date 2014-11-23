<?php namespace Orchestra\Control;

use Orchestra\Contracts\Foundation\Foundation;

class ControlMenuHandler
{
    /**
     * ACL instance.
     *
     * @var \Orchestra\Contracts\Auth\Acl\Acl
     */
    protected $acl;

    /**
     * Menu instance.
     *
     * @var \Orchestra\Widget\Handlers\Menu
     */
    protected $menu;

    /**
     * Construct a new handler.
     *
     * @param  \Orchestra\Contracts\Foundation\Foundation  $foundation
     */
    public function __construct(Foundation $foundation)
    {
        $this->menu = $foundation->menu();
        $this->acl = $foundation->acl();
    }

    /**
     * Create a handler for `orchestra.ready: admin` event.
     *
     * @return void
     */
    public function handle()
    {
        if (! ($this->acl->can('manage roles') || $this->acl->can('manage acl'))) {
            return ;
        }

        $this->menu->add('control', '^:extension')
            ->title('Control')
            ->link(handles('orchestra::control'));
    }
}
