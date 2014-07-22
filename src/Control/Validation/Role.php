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
     * List of events.
     * 
     * @var array
     */
    protected $events = array(
        'orchestra.control.validate: roles',
    );

    /**
     * On create validations.
     *
     * @return void
     */
    protected function onCreate()
    {
        $this->rules['name'][] = 'unique:roles,name';
    }

    /**
     * On update validations.
     *
     * @return void
     */
    protected function onUpdate()
    {
        $this->rules['name'][] = 'unique:roles,name,{roleID}';
    }
}
