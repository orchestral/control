<?php

Orchestra\Config::map('orchestra/control', array(
	'localtime' => 'orchestra/control::localtime.enable'
));

Event::listen('orchestra.form: extension.orchestra/form', 'Orchestra\Control\Timezone\ConfigHandler@onViewForm');

Event::listen('orchestra.form: user.account', 'Orchestra\Control\Timezone\UserHandler@onViewForm');
Event::listen('orchestra.saved: user.account', 'Orchestra\Control\Timezone\UserHandler@onSaved');
