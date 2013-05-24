<?php namespace Orchestra\Control\Timezone;

class UserHandler {

	/**
	 * Handle `orchestra.form: user.account` event.
	 *
	 * @access public
	 * @param  Orchestra\Model\User             $user
	 * @param  Orchestra\Html\Form\FormBuilder  $form
	 * @return void
	 */
	public function onViewForm($user, $form)
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
	}

	/**
	 * Handle `orchestra.saved: user.account` event.
	 *
	 * @access public
	 * @param  Orchestra\Model\User $user
	 * @return void
	 */
	public function onSaved($user)
	{
		if (false === Config::get('orchestra/control::localtime.enable', false)) return;

		$userId   = $user->id;
		$userMeta = Orchestra\Memory::make('user');

		$userMeta->put("timezone.{$userId}", Input::get('meta_timezone'));
	}
}
