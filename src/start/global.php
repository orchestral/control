<?php

Orchestra\Config::map('orchestra/control', array(
	'localtime' => 'orchestra/control::localtime.enable'
));

Event::listen('orchestra.form: extension.orchestra/control', 'Orchestra\Control\ExtensionConfigHandler@onViewForm');
Event::listen('orchestra.saved: extension.orchestra/control', 'Orchestra\Control\ExtensionConfigHandler@onSaved');
