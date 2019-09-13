<?php

namespace Orchestra\Control\Listeners\Timezone;

use Orchestra\Contracts\Html\Form\Builder as FormBuilder;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Control\Listeners\Timezone;
use Orchestra\Support\Timezone as TimezoneCollection;

class OnShowAccount extends Timezone
{
    /**
     * Handle `orchestra.form: user.account` event.
     *
     * @param  \Orchestra\Model\User  $user
     * @param  \Orchestra\Contracts\Html\Form\Builder  $form
     *
     * @return void
     */
    public function handle($user, FormBuilder $form)
    {
        if (! $this->isLocaltimeEnabled()) {
            return;
        }

        $form->extend(static function (FormGrid $form) {
            $form->fieldset('Timezone', static function (Fieldset $fieldset) {
                $fieldset->control('select', 'timezone')
                    ->label('Timezone')
                    ->options(TimezoneCollection::pluck('name', 'code'))
                    ->value(static function ($user) {
                        return $user->timezone;
                    });
            });
        });
    }
}
