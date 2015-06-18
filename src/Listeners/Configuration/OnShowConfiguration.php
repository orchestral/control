<?php namespace Orchestra\Control\Listeners\Configuration;

use Orchestra\Model\Role;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Control\Listeners\Configuration;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Contracts\Html\Form\Builder as FormBuilder;

class OnShowConfiguration extends Configuration
{
    /**
     * Handle `orchestra.form: extension.orchestra/control` event.
     *
     * @param  \Orchestra\Model\User  $model
     * @param  \Orchestra\Contracts\Html\Form\Builder  $form
     *
     * @return void
     */
    public function handle($model, FormBuilder $form)
    {
        $form->extend(function (FormGrid $form) {
            $form->fieldset('Role Configuration', function (Fieldset $fieldset) {
                $roles = Role::lists('name', 'id');

                $fieldset->control('select', 'admin_role')
                    ->label(trans('orchestra/control::label.roles.admin'))
                    ->options($roles);

                $fieldset->control('select', 'member_role')
                    ->label(trans('orchestra/control::label.roles.member'))
                    ->options($roles);
            });

            $form->fieldset('Timezone', function (Fieldset $fieldset) {
                $agreement = ['yes' => 'Yes', 'no'  => 'No'];

                $fieldset->control('select', 'localtime')
                    ->attributes(['role' => 'agreement'])
                    ->label(trans('orchestra/control::label.enable-timezone'))
                    ->options($agreement)
                    ->value(function ($row) {
                        return ($row->localtime === true) ? 'yes' : 'no';
                    });
            });
        });
    }
}
