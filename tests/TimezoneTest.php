<?php namespace Orchestra\Control\TestCase;

use Orchestra\Control\Timezone;

class TimezoneTest extends \PHPUnit_Framework_TestCase
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
