<?php namespace Orchestra\Control\Tests;

class TimezoneTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Test Orchestra\Control\Timezone::lists() method
	 *
	 * @test
	 */
	public function testTimezoneListsMethod()
	{
		$list = \Orchestra\Control\Timezone::lists();

		$this->assertTrue(array_key_exists('UTC', $list));
		$this->assertTrue(array_key_exists('Asia/Kuala_Lumpur', $list));
	}
}
