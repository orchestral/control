<?php namespace Orchestra\Control\Timezone;

class ConfigHandler {
	
	public function onViewForm($model, $form)
	{
		$form->extend(function ($form)
		{
			$form->fieldset('Timezone', function ($fieldset)
			{
				$fieldset->control('select', 'localtime', function($control)
				{
					$control->attributes(array('role' => 'switcher'));
					$control->label('Enable Timezone');
					$control->options(array(
						'yes' => 'Yes',
						'no'  => 'No',
					));
					$control->value(function ($row)
					{
						return ($row->localtime === true) ? 'yes' : 'no';
					});
				});
			});
		});
	}
}
