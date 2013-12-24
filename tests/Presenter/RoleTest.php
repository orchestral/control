<?php namespace Orchestra\Control\TestCase;

use Mockery as m;
use Orchestra\Control\Presenter\Role;
use Orchestra\Support\Facades\Form;
use Orchestra\Support\Facades\Table;

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
     * Test constructing Orchestra\Control\Presenter\Role.
     *
     * @test
     */
    public function testContructMethod()
    {
        $stub = new Role;
    }

    /**
     * Test Orchestra\Control\Presenter\Role::table() method.
     *
     * @test
     */
    public function testTableMethod()
    {
        $table = m::mock('\Orchestra\Html\Table\Environment');
        $model = m::mock('\Orchestra\Model\Role');

        $table->shouldReceive('of')->once()->with('control.roles', m::type('Closure'))
            ->andReturnUsing(function ($n, $c) {
                return true;
            });
        $stub = new Role;

        Table::swap($table);

        $this->assertTrue($stub->table($model));
    }

    /**
     * Test Orchestra\Control\Presenter\Role::form() method.
     *
     * @test
     */
    public function testFormMethod()
    {
        $form = m::mock('\Orchestra\Html\Form\Environment');
        $model = m::mock('\Orchestra\Model\Role');

        $form->shouldReceive('of')->once()->with('control.roles', m::type('Closure'))
            ->andReturnUsing(function ($n, $c) {
                return true;
            });
        $stub = new Role;

        Form::swap($form);

        $this->assertTrue($stub->form($model));
    }
}
