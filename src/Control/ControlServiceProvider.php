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

        $this->mapExtensionConfig();

        $this->bootExtensionEvents();

        $this->bootTimezoneEvents();

        require_once "{$path}/filters.php";
        require_once "{$path}/routes.php";
    }

    /**
     * Boot extension events.
     *
     * @return void
     */
    protected function bootExtensionEvents()
    {
        $events  = $this->app['events'];
        $handler = 'Orchestra\Control\ExtensionConfigHandler';

        $events->listen('orchestra.form: extension.orchestra/control', "{$handler}@onViewForm");
        $events->listen('orchestra.saved: extension.orchestra/control', "{$handler}@onSaved");
    }

    /**
     * Boot timezone events.
     *
     * @return void
     */
    protected function bootTimezoneEvents()
    {
        $events = $this->app['events'];
        $handler = 'Orchestra\Control\Timezone\UserHandler';

        $events->listen('orchestra.form: user.account', "{$handler}onViewForm");
        $events->listen('orchestra.saved: user.account', "{$handler}@onSaved");
    }

    /**
     * Map extension config.
     *
     * @return void
     */
    protected function mapExtensionConfig()
    {
        $this->app['orchestra.extension.config']->map('orchestra/control', [
            'localtime'   => 'orchestra/control::localtime.enable',
            'admin_role'  => 'orchestra/foundation::roles.admin',
            'member_role' => 'orchestra/foundation::roles.member'
        ]);
    }
}
