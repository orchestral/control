<?php

Event::listen('orchestra.form: user.account', 'Orchestra\Control\Timezone\UserHandler@onViewForm');
Event::listen('orchestra.saved: user.account', 'Orchestra\Control\Timezone\UserHandler@onSaved');
