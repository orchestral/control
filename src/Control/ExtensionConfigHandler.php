<?php namespace Orchestra\Control;

use Orchestra\Model\Role;
use Illuminate\Support\Fluent;
use Illuminate\Support\Facades\Config;
use Orchestra\Support\Facades\Foundation;

class ExtensionConfigHandler
{
    /**
     * Handle `orchestra.form: extension.orchestra/control` event.
     *
     * @param  \Orchestra\Model\User            $model
     * @param  \Orchestra\Html\Form\FormBuilder $form
     * @return void
     */
    public function onViewForm($model, $form)
    {
        $form->extend(function ($form) {
            $form->fieldset('Role Configuration', function ($fieldset) {
                $roles = Role::lists('name', 'id');

                $fieldset->control('select', 'admin_role')
                    ->label(trans('orchestra/control::label.roles.admin'))
                    ->options($roles);

                $fieldset->control('select', 'member_role')
                    ->label(trans('orchestra/control::label.roles.member'))
                    ->options($roles);
            });

            $form->fieldset('Timezone', function ($fieldset) {
                $fieldset->control('select', 'localtime')
                    ->attributes(['role' => 'switcher'])
                    ->label(trans('orchestra/control::label.enable-timezone'))
                    ->options([
                        'yes' => 'Yes',
                        'no'  => 'No',
                    ])
                    ->value(function ($row) {
                        return ($row->localtime === true) ? 'yes' : 'no';
                    });
            });
        });
    }

    /**
     * Handle `orchestra.saved: extension.orchestra/control` event.
     *
     * @param  \Illuminate\Support\Fluent  $input
     * @return void
     */
    public function onSaved(Fluent $input)
    {
        $localtime = ($input['localtime'] === 'yes');

        Config::set('orchestra/foundation::roles.admin', (int) $input['admin_role']);
        Config::set('orchestra/foundation::roles.member', (int) $input['member_role']);

        Role::setDefaultRoles(Config::get('orchestra/foundation::roles'));

        Authorize::sync();

        Foundation::memory()->put("extension_orchestra/control.localtime", $localtime);
    }
}
