<?php

namespace spec\Orchestra\Control\Command;

use Illuminate\Contracts\Foundation\Application;
use Orchestra\Contracts\Authorization\Authorization;
use PhpSpec\ObjectBehavior;

class SynchronizerSpec extends ObjectBehavior
{
    function let(Application $app, Authorization $acl)
    {
        $this->beConstructedWith($app, $acl);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Orchestra\Control\Command\Synchronizer');
        $this->shouldHaveType('Orchestra\Control\Contracts\Command\Synchronizer');
    }

    function it_should_be_synced(Application $app, Authorization $acl, Role $role)
    {
        $this->beConstructedWith($app, $acl);

        $admin = (object)['id' => 1, 'name' => 'Administrator'];

        $app->make('orchestra.role')->willReturn($role);
        $role->admin()->willReturn($admin);

        $acl->allow('Administrator', ['Manage Users', 'Manage Orchestra', 'Manage Roles', 'Manage Acl'])
            ->shouldBeCalled(1)->willReturn(null);

        $this->handle()->shouldReturn(null);
    }
}

class Role
{
    public function admin()
    {
        //
    }
}