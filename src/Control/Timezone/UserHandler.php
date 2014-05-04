<?php namespace Orchestra\Control\Timezone;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Orchestra\Control\Timezone;
use Orchestra\Support\Facades\Memory;

class UserHandler
{
    /**
     * Handle `orchestra.form: user.account` event.
     *
     * @param  \Orchestra\Model\User            $user
     * @param  \Orchestra\Html\Form\FormBuilder $form
     * @return void
     */
    public function onViewForm($user, $form)
    {
        if (false === Config::get('orchestra/control::localtime.enable', false)) {
            return;
        }

        $form->extend(function ($form) {
            $form->fieldset('Timezone', function ($fieldset) {
                $fieldset->control('select', 'meta_timezone', function ($control) {
                    $control->label('Timezone');
                    $control->options(Timezone::lists());
                    $control->value(function ($row) {
                        $meta = Memory::make('user');

                        return $meta->get("timezone.{$row->id}", Config::get('app.timezone'));
                    });
                });
            });
        });
    }

    /**
     * Handle `orchestra.saved: user.account` event.
     *
     * @param  \Orchestra\Model\User   $user
     * @return void
     */
    public function onSaved($user)
    {
        if (false === Config::get('orchestra/control::localtime.enable', false)) {
            return;
        }

        $userId = $user->id;
        $meta   = Memory::make('user');

        $meta->put("timezone.{$userId}", Input::get('meta_timezone'));
    }
}
