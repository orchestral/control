<?php

Orchestra\Config::map('orchestra/control', array(
	'localtime'   => 'orchestra/control::localtime.enable',
	'admin_role'  => 'orchestra/foundation::roles.admin',
	'member_role' => 'orchestra/foundation::roles.member'
));

Event::listen('orchestra.form: extension.orchestra/control', 'Orchestra\Control\ExtensionConfigHandler@onViewForm');
Event::listen('orchestra.saved: extension.orchestra/control', 'Orchestra\Control\ExtensionConfigHandler@onSaved');
