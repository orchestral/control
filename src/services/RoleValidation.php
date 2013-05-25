<?php namespace Orchestra\Control\Services;

use Orchestra\Support\Validator;

class RoleValidation extends Validator {

	/**
	 * List of rules
	 *
	 * @var array
	 */
	protected static $rules = array(
		'name' => array('required'),
	);

	/**
	 * On create validations.
	 *
	 * @access public
	 * @return void
	 */
	protected function onCreate()
	{
		static::$rules['name'][] = 'unique:roles,name';
	}

	/**
	 * On update validations.
	 *
	 * @access public
	 * @return void
	 */
	protected function onUpdate()
	{
		static::$rules['name'][] = 'unique:roles,name,{roleID}';
	}
}
