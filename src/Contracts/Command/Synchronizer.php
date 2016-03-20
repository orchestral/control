<?php

namespace Orchestra\Control\Contracts\Command;

interface Synchronizer
{
    /**
     * Re-sync administrator access control.
     *
     * @return void
     */
    public function handle();
}
