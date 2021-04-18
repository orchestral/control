<?php

namespace Orchestra\Control;

use Orchestra\Control\Listeners\Configuration\OnUpdateConfiguration;
use Orchestra\Foundation\Support\Providers\ModuleServiceProvider;

class ControlServiceProvider extends ModuleServiceProvider
{
    /**
     * The application or extension namespace.
     *
     * @var string|null
     */
    protected $namespace = 'Orchestra\Control\Http\Controllers';

    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'orchestra.saved: extension.orchestra/control' => [OnUpdateConfiguration::class],
    ];

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
     * Boot extension components.
     *
     * @return void
     */
    protected function bootExtensionComponents()
    {
        $path = \realpath(__DIR__.'/../');

        $this->addConfigComponent('orchestra/control', 'orchestra/control', "{$path}/config");
        $this->addLanguageComponent('orchestra/control', 'orchestra/control', "{$path}/resources/lang");
        $this->addViewComponent('orchestra/control', 'orchestra/control', "{$path}/resources/views");

        $this->loadMigrationsFrom([
            "{$path}/database/migrations",
        ]);
    }

    /**
     * Boot extension routing.
     *
     * @return void
     */
    protected function loadRoutes()
    {
        $path = \realpath(__DIR__.'/../');

        $this->loadBackendRoutesFrom("{$path}/routes/backend.php");
    }
}
