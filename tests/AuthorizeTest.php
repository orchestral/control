<?php namespace Orchestra\Control\TestCase;

use Mockery as m;
use Orchestra\Control\Authorize;
use Illuminate\Support\Facades\Facade;
use Orchestra\Support\Facades\Foundation;

class AuthorizeTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $app = new \Illuminate\Foundation\Application;

        Facade::clearResolvedInstances();
        Facade::setFacadeApplication($app);
    }

    /**
     * Test Orchestra\Control\Authorize::sync() method.
     *
     * @test
     */
    public function testSyncMethod()
    {
        $app  = m::mock('\Orchestra\Foundation\Application')->shouldDeferMissing();
        $acl  = m::mock('\Orchestra\Auth\Acl\Container');
        $role = m::mock('Role');

        $admin = (object) array(
            'id'   => 1,
            'name' => 'Administrator',
        );

        $app->shouldReceive('acl')->once()->andReturn($acl)
            ->shouldReceive('make')->once()->with('orchestra.role')->andReturn($role);
        $acl->shouldReceive('allow')->once()
                ->with('Administrator', array('Manage Users', 'Manage Orchestra', 'Manage Roles', 'Manage Acl'))
                ->andReturn(null);
        $role->shouldReceive('admin')->once()->andReturn($admin);

        Foundation::swap($app);

        Authorize::sync();
    }
}
