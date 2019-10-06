<?php

namespace Orchestra\Control\Listeners\Timezone;

use Illuminate\Support\Facades\Request;
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

        $user->timezone = Request::input('timezone');
    }
}
