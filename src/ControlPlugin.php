<?php

namespace Orchestra\Control;

use Orchestra\Model\Role;
use Illuminate\Support\Fluent;
use Orchestra\Extension\Plugin;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Control\Http\Handlers\ControlMenuHandler;
use Orchestra\Contracts\Html\Form\Builder as FormBuilder;

class ControlPlugin extends Plugin
{
    /**
     * Extension name.
     *
     * @var string
     */
    protected $extension = 'orchestra/control';

    /**
     * Configuration.
     *
     * @var array
     */
    protected $config = [
        'localtime' => 'orchestra/control::localtime.enable',
        'admin_role' => 'orchestra/foundation::roles.admin',
        'member_role' => 'orchestra/foundation::roles.member',
    ];

    /**
     * Menu handler.
     *
     * @var object|null
     */
    protected $menu = ControlMenuHandler::class;

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * Setup the form.
     *
     * @param  \Illuminate\Support\Fluent $model
     * @param  \Orchestra\Contracts\Html\Form\Builder  $form
     *
     * @return void
     */
    protected function form(Fluent $model, FormBuilder $form)
    {
        $form->extend(static function (FormGrid $form) {
            $form->fieldset('Role Configuration', static function (Fieldset $fieldset) {
                $roles = Role::pluck('name', 'id');

                $fieldset->control('select', 'admin_role')
                    ->label(\trans('orchestra/control::label.roles.admin'))
                    ->options($roles);

                $fieldset->control('select', 'member_role')
                    ->label(\trans('orchestra/control::label.roles.member'))
                    ->options($roles);
            });

            $form->fieldset('Timezone', static function (Fieldset $fieldset) {
                $agreement = ['yes' => 'Yes', 'no' => 'No'];

                $fieldset->control('select', 'localtime')
                    ->attributes(['role' => 'agreement'])
                    ->label(\trans('orchestra/control::label.enable-timezone'))
                    ->options($agreement)
                    ->value(static function ($field) {
                        return ($field->localtime === true) ? 'yes' : 'no';
                    });
            });
        });
    }
}
