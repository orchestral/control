<?php namespace Orchestra\Control\Validation;

use Orchestra\Support\Keyword;
use Orchestra\Support\Validator;
use Orchestra\Support\Facades\Foundation;
use Illuminate\Contracts\Validation\Validator as ValidatorResolver;

class Role extends Validator
{
    /**
     * List of rules.
     *
     * @var array
     */
    protected $rules = [
        'name' => ['required', 'not_in:guest'],
    ];

    /**
     * List of events.
     *
     * @var array
     */
    protected $events = [
        'orchestra.control.validate: roles',
    ];

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

    /**
     * Extend create validations.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     *
     * @return void
     */
    protected function extendCreate(ValidatorResolver $validator)
    {
        $name = Keyword::make($validator->getData()['name']);

        $validator->after(function (ValidatorResolver $v) use ($name) {
            if ($this->isRoleNameAlreadyUsed($name)) {
                $v->errors()->add('name', trans('orchestra/control::response.roles.reserved-word'));
            }
        });
    }

    /**
     * Extend update validations.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     *
     * @return void
     */
    protected function extendUpdate(ValidatorResolver $validator)
    {
        $name = Keyword::make($validator->getData()['name']);

        $validator->after(function (ValidatorResolver $v) use ($name) {
            if ($this->isRoleNameGuest($name)) {
                $v->errors()->add('name', trans('orchestra/control::response.roles.reserved-word'));
            }
        });
    }

    /**
     * Check if role name is already used.
     *
     * @param  \Orchestra\Support\Keyword  $name
     *
     * @return bool
     */
    protected function isRoleNameAlreadyUsed(Keyword $name)
    {
        $roles = Foundation::acl()->roles()->get();

        return $name->searchIn($roles) !== false;
    }

    /**
     * Check if role name is "guest".
     *
     * @param  \Orchestra\Support\Keyword  $name
     *
     * @return bool
     */
    protected function isRoleNameGuest(Keyword $name)
    {
        return $name->searchIn(['guest']) !== false;
    }
}
