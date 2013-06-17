<?php namespace Orchestra\Control;

use Illuminate\Support\Facades\Config;
use Orchestra\Support\Facades\App;

class ExtensionConfigHandler {
	
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
			$form->fieldset('Role Configuration', function ($fieldset)
			{
				$fieldset->control('select', 'admin_role', function($control)
				{
					$control->label(trans('orchestra/control::label.roles.admin'));
					$control->options(Role::lists('name', 'id'));
				});
				$fieldset->control('select', 'member_role', function($control)
				{
					$control->label(trans('orchestra/control::label.roles.member'));
					$control->options(Role::lists('name', 'id'));
				});

			});

			$form->fieldset('Timezone', function ($fieldset)
			{
				$fieldset->control('select', 'localtime', function($control)
				{
					$control->attributes(array('role' => 'switcher'));
					$control->label(trans('orchestra/control::label.enable-timezone'));
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

		Config::set('orchestra/foundation::roles.admin', (int) $input['admin_role']);
		Config::set('orchestra/foundation::roles.member', (int) $input['member_role']);

		Authorize::sync();

		App::memory()->put("extension_orchestra/control.localtime", $localtime);
	}
}
