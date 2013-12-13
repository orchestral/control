<?php namespace Orchestra\Control\Validation;

use Orchestra\Support\Validator;

class Role extends Validator
{
    /**
     * List of rules
     *
     * @var array
     */
    protected $rules = array(
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
        $this->rules['name'][] = 'unique:roles,name';
    }

    /**
     * On update validations.
     *
     * @access public
     * @return void
     */
    protected function onUpdate()
    {
        $this->rules['name'][] = 'unique:roles,name,{roleID}';
    }
}
