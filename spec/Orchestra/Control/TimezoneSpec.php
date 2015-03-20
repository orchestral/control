<?php

namespace spec\Orchestra\Control;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TimezoneSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Orchestra\Control\Timezone');
    }

    function it_should_contains()
    {
        $this::lists()->shouldHaveKey('UTC');
        $this::lists()->shouldHaveKey('Asia/Kuala_Lumpur');
    }
}
