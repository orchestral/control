<?php namespace Orchestra\Control\Tests;

use Orchestra\Foundation\Services\ApplicationTestCase;

class AuthorizeTest extends ApplicationTestCase {

	protected function getEnvironmentSetUp($app)
	{
		parent::getEnvironmentSetUp($app);

		$app['path.base'] = __DIR__.'/../';
		$app['config']->set('database.default', 'testbench');
		$app['config']->set('database.connections.testbench', array(
			'driver'    => 'sqlite',
			'database'  => ':memory:',
			'prefix'    => '',
		));
	}

	/**
	 * Test Orchestra\Control\Authorize::sync() method.
	 *
	 * @test
	 */
	public function testSyncMethod()
	{
		$role = $this->app['orchestra.role']->admin();
		$acl  = $this->app['orchestra.app']->acl();

		$acl->deny($role->name, 'Manage Orchestra');

		$this->assertFalse($acl->can('Manage Orchestra'));

		//\Orchestra\Control\Authorize::sync();	
	}
}
