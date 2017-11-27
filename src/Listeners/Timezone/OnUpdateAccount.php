<?php

namespace Orchestra\Control\Listeners\Timezone;

use Illuminate\Support\Facades\Input;
use Orchestra\Control\Listeners\Timezone;

class OnUpdateAccount extends Timezone
{
    /**
     * Handle `orchestra.saved: user.account` event.
     *
     * @param  \Orchestra\Model\User  $user
     *
     * @return void
     */
    public function handle($user)
    {
        if (! $this->isLocaltimeEnabled()) {
            return;
        }

        $userId = $user->getAttribute('id');
        $meta = $this->memory->make('user');

        $meta->put("timezone.{$userId}", Input::get('meta_timezone'));
    }
}
