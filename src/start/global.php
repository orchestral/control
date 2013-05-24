<?php

Orchestra\Config::map('orchestra/control', array(
	'localtime' => 'orchestra/control::localtime.enable'
));

Event::listen('orchestra.form: extension.orchestra/control', 'Orchestra\Control\ConfigHandler@onViewForm');
Event::listen('orchestra.saving: extension.orchestra/control', 'Orchestra\Control\ConfigHandler@onSaving');
