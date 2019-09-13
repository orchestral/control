<?php

namespace Orchestra\Control\Listeners\Configuration;

use Illuminate\Support\Fluent;
use Orchestra\Control\Listeners\Configuration;
use Orchestra\Model\Role;

class OnUpdateConfiguration extends Configuration
{
    /**
     * Handle `orchestra.saved: extension.orchestra/control` event.
     *
     * @param  \Illuminate\Support\Fluent  $input
     *
     * @return void
     */
    public function handle(Fluent $input)
    {
        $localtime = ($input['localtime'] === 'yes');

        $this->config->set('orchestra/foundation::roles.admin', (int) $input['admin_role']);
        $this->config->set('orchestra/foundation::roles.member', (int) $input['member_role']);

        Role::setDefaultRoles($this->config->get('orchestra/foundation::roles'));

        $this->synchronizer->handle();

        $this->memory->put('extension_orchestra/control.localtime', $localtime);
    }
}
