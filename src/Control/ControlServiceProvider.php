<?php namespace Orchestra\Control;

use Illuminate\Support\ServiceProvider;

class ControlServiceProvider extends ServiceProvider
{
    /**
     * Register service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the service provider
     *
     * @return void
     */
    public function boot()
    {
        $path = realpath(__DIR__.'/../');

        $this->package('orchestra/control', 'orchestra/control', $path);

        require_once "{$path}/start/global.php";
        require_once "{$path}/start/localtime.php";
        require_once "{$path}/filters.php";
        require_once "{$path}/routes.php";
    }
}
