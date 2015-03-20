<?php

namespace spec\Orchestra\Control\Http\Handlers;

use Illuminate\Contracts\Container\Container;
use Orchestra\Contracts\Authorization\Authorization;
use Orchestra\Widget\Handlers\Menu;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ControlMenuHandlerSpec extends ObjectBehavior
{
    function let(Container $app)
    {
        $this->beConstructedWith($app);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Orchestra\Control\Http\Handlers\ControlMenuHandler');
    }

    function it_should_be_child_of_extensions(Container $app, Menu $menu)
    {
        $this->beConstructedWith($app);

        $app->make('orchestra.platform.menu')->shouldBeCalled(1)->willReturn($menu);

        $menu->has('extensions')->shouldBeCalled(1)->willReturn(true);

        $this->getPositionAttribute()->shouldReturn('^:extensions');
    }

    function it_should_be_next_to_home(Container $app, Menu $menu)
    {
        $this->beConstructedWith($app);

        $app->make('orchestra.platform.menu')->shouldBeCalled(1)->willReturn($menu);

        $menu->has('extensions')->shouldBeCalled(1)->willReturn(false);

        $this->getPositionAttribute()->shouldReturn('>:home');
    }

    function it_is_authorized(Authorization $acl)
    {
        $acl->can('manage roles')->shouldBeCalled(1)->willReturn(false);
        $acl->can('manage acl')->shouldBeCalled(1)->willReturn(true);

        $this->authorize($acl)->shouldReturn(true);
    }

    function it_not_authorized(Authorization $acl)
    {
        $acl->can('manage roles')->shouldBeCalled(1)->willReturn(false);
        $acl->can('manage acl')->shouldBeCalled(1)->willReturn(false);

        $this->authorize($acl)->shouldReturn(false);
    }
}
