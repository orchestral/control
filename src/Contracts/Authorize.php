<?php namespace Orchestra\Control\Contracts; 

interface Authorize
{
    /**
     * Re-sync administrator access control.
     *
     * @return void
     */
    public function sync();
}
