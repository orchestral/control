<?php

Event::listen('orchestra.form: user.account', function ($user, $form)
{
	if (false === Config::get('orchestra/control::localtime.enable', false)) return;

	$form->extend(function ($form)
	{
		$form->fieldset('Timezone', function ($fieldset)
		{
			$fieldset->control('select', 'meta_timezone', function ($control)
			{
				$control->label   = 'Timezone';
				$control->options = Orchestra\Control\Timezone::lists();
				$control->value   = function ($row)
				{
					$userMeta = Orchestra\Memory::make('user');

					return $userMeta->get("timezone.{$row->id}", Config::get('app.timezone'));
				};
			});
		});
	});
});

Event::listen('orchestra.saved: user.account', function ($user)
{
	if (false === Config::get('orchestra/control::localtime.enable', false)) return;
	
	$userId   = $user->id;
	$userMeta = Orchestra\Memory::make('user');

	$userMeta->put("timezone.{$userId}", Input::get('meta_timezone'));
});
