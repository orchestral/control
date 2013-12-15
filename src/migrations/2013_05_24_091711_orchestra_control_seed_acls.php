<?php

use Illuminate\Database\Migrations\Migration;
use Orchestra\Support\Facades\App;
use Orchestra\Model\Role;

class OrchestraControlSeedAcls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $role = Role::admin();
        $acl  = App::acl();

        $actions = array('Manage Roles', 'Manage Acl');

        $acl->actions()->attach($actions);
        $acl->allow($role->name, $actions);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Nothing to do here.
    }
}
