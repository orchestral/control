<?php namespace Orchestra\Control\Tests;

use Orchestra\Control\Timezone;

class TimezoneTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test Orchestra\Control\Timezone::lists() method
     *
     * @test
     */
    public function testTimezoneListsMethod()
    {
        $list = Timezone::lists();

        $this->assertTrue(array_key_exists('UTC', $list));
        $this->assertTrue(array_key_exists('Asia/Kuala_Lumpur', $list));
    }
}
