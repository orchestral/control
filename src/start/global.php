<?php

use Illuminate\Support\Facades\Event;
use Orchestra\Support\Facades\Config;

/*
|--------------------------------------------------------------------------
| Map Configuration to Memory
|--------------------------------------------------------------------------
*/

Config::map('orchestra/control', [
    'localtime'   => 'orchestra/control::localtime.enable',
    'admin_role'  => 'orchestra/foundation::roles.admin',
    'member_role' => 'orchestra/foundation::roles.member'
]);

/*
|--------------------------------------------------------------------------
| Attach Events
|--------------------------------------------------------------------------
*/

Event::listen('orchestra.form: extension.orchestra/control', 'Orchestra\Control\ExtensionConfigHandler@onViewForm');
Event::listen('orchestra.saved: extension.orchestra/control', 'Orchestra\Control\ExtensionConfigHandler@onSaved');
