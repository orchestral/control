<?php

use Illuminate\Database\Migrations\Migration;
use Orchestra\Model\Role;
use Orchestra\Support\Facades\Foundation;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $role = Role::admin();
        $acl = Foundation::acl();

        $actions = ['Manage Roles', 'Manage Acl'];

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
};
