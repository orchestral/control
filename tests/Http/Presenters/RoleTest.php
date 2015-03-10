<?php namespace Orchestra\Control\Http\Presenters\TestCase;

use Mockery as m;
use Orchestra\Support\Facades\Table;
use Orchestra\Control\Http\Presentersrs\Role;

class RoleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Teardown the test environment.
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * Test constructing Orchestra\Control\Http\Presenters\Role.
     *
     * @test
     */
    public function testContructMethod()
    {
        $config = m::mock('\Illuminate\Contracts\Config\Repository');
        $form   = m::mock('\Orchestra\Contracts\Html\Form\Factory');
        $table  = m::mock('\Orchestra\Contracts\Html\Table\Factory');

        $stub = new Role($config, $form, $table);

        $this->assertInstanceOf('\Orchestra\Contracts\Html\Form\Presenter', $stub);
    }

    /**
     * Test Orchestra\Control\Http\Presenters\Role::table() method.
     *
     * @test
     */
    public function testTableMethod()
    {
        $config = m::mock('\Illuminate\Contracts\Config\Repository');
        $form   = m::mock('\Orchestra\Contracts\Html\Form\Factory');
        $table  = m::mock('\Orchestra\Contracts\Html\Table\Factory');
        $model  = m::mock('\Orchestra\Model\Role');

        $table->shouldReceive('of')->once()->with('control.roles', m::type('Closure'))
            ->andReturnUsing(function ($n, $c) {
                return true;
            });
        $stub = new Role($config, $form, $table);

        Table::swap($table);

        $this->assertTrue($stub->table($model));
    }

    /**
     * Test Orchestra\Control\Http\Presenters\Role::form() method.
     *
     * @test
     */
    public function testFormMethod()
    {
        $config = m::mock('\Illuminate\Contracts\Config\Repository');
        $form   = m::mock('\Orchestra\Contracts\Html\Form\Factory');
        $table  = m::mock('\Orchestra\Contracts\Html\Table\Factory');
        $model  = m::mock('\Orchestra\Model\Role');

        $form->shouldReceive('of')->once()->with('control.roles', m::type('Closure'))
            ->andReturnUsing(function ($n, $c) {
                return true;
            });
        $stub = new Role($config, $form, $table);

        $this->assertTrue($stub->form($model));
    }
}
