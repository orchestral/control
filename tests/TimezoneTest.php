<?php

namespace Orchestra\Control\TestCase;

use Orchestra\Control\Timezone;
use PHPUnit\Framework\TestCase;

class TimezoneTest extends TestCase
{
    public function testItIsInitializable()
    {
        $stub = new Timezone();

        $this->assertInstanceOf(Timezone::class, $stub);
    }

    public function testItShouldContains()
    {
        $timezones = Timezone::pluck();

        $this->assertArrayHasKey('UTC', $timezones);
        $this->assertArrayHasKey('Asia/Kuala_Lumpur', $timezones);
    }
}
