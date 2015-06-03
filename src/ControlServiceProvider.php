<?php namespace Orchestra\Control;

use Orchestra\Control\Command\Synchronizer;
use Orchestra\Control\Timezone\UserHandler;
use Orchestra\Support\Providers\ServiceProvider;
use Orchestra\Control\Http\Handlers\ControlMenuHandler;
use Orchestra\Control\Contracts\Command\Synchronizer as SynchronizerContract;

class ControlServiceProvider extends ServiceProvider
{
    /**
     * Register service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SynchronizerContract::class, Synchronizer::class);
    }

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $path = realpath(__DIR__.'/../');

        $this->addConfigComponent('orchestra/control', 'orchestra/control', "{$path}/resources/config");
        $this->addLanguageComponent('orchestra/control', 'orchestra/control', "{$path}/resources/lang");
        $this->addViewComponent('orchestra/control', 'orchestra/control', "{$path}/resources/views");

        $this->mapExtensionConfig();
        $this->bootExtensionEvents();
        $this->bootExtensionRouting($path);
        $this->bootExtensionMenuEvents();
        $this->bootTimezoneEvents();
    }

    /**
     * Boot extension events.
     *
     * @return void
     */
    protected function bootExtensionEvents()
    {
        $events  = $this->app['events'];
        $handler = ExtensionConfigHandler::class;

        $events->listen('orchestra.form: extension.orchestra/control', "{$handler}@onViewForm");
        $events->listen('orchestra.saved: extension.orchestra/control', "{$handler}@onSaved");
    }

    /**
     * Boot extension menu handler.
     *
     * @return void
     */
    protected function bootExtensionMenuEvents()
    {
        $this->app['events']->listen('orchestra.ready: admin', ControlMenuHandler::class);
    }

    /**
     * Boot extension routing.
     *
     * @param  string  $path
     *
     * @return void
     */
    protected function bootExtensionRouting($path)
    {
        require_once "{$path}/src/routes.php";
    }

    /**
     * Boot timezone events.
     *
     * @return void
     */
    protected function bootTimezoneEvents()
    {
        $events  = $this->app['events'];
        $handler = UserHandler::class;

        $events->listen('orchestra.form: user.account', "{$handler}@onViewForm");
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
            'member_role' => 'orchestra/foundation::roles.member',
        ]);
    }
}
