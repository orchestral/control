<?php namespace Orchestra\Control;

use Orchestra\Support\Facades\App;

class ConfigHandler {
	
	/**
	 * Handle `orchestra.form: extension.orchestra/control` event.
	 *
	 * @access public
	 * @param  Orchestra\Model\User             $model
	 * @param  Orchestra\Html\Form\FormBuilder  $form
	 * @return void
	 */
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

	/**
	 * Handle `orchestra.saved: extension.orchestra/control` event.
	 *
	 * @access public
	 * @param  array    $input
	 * @return void
	 */
	public function onSaved($input)
	{
		$localtime = ($input['localtime'] === 'yes');

		App::memory()->put("extension_orchestra/control.localtime", $localtime);
	}
}
