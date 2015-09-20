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
        $this->disallowReservedRoleName($validator);
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
        $this->disallowReservedRoleName($validator);
    }

    /**
     * Disallow reseerved role name.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     *
     * @return void
     */
    protected function disallowReservedRoleName(ValidatorResolver $validator)
    {
        $validator->after(function (ValidatorResolver $v) {
            if ($this->roleNameIsAlreadyUsed($v->getData()['name'])) {
                $v->errors()->add('name', trans('orchestra/control::response.roles.reserved-word'));
            }
        });
    }

    /**
     * Check if role name is already used.
     *
     * @param  string  $name
     *
     * @return bool
     */
    protected function roleNameIsAlreadyUsed($name)
    {
        $keyword = Keyword::make($name);
        $roles   = Foundation::acl()->roles()->get();

        return $keyword->searchIn($roles) >= 0;
    }
}
