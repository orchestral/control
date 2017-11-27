<?php

namespace Orchestra\Control;

use Orchestra\Control\Command\Synchronizer;
use Orchestra\Control\Listeners\Timezone\OnShowAccount;
use Orchestra\Control\Listeners\Timezone\OnUpdateAccount;
use Orchestra\Foundation\Support\Providers\ModuleServiceProvider;
use Orchestra\Control\Listeners\Configuration\OnUpdateConfiguration;
use Orchestra\Control\Contracts\Command\Synchronizer as SynchronizerContract;

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

        'orchestra.form: user.account' => [OnShowAccount::class],
        'orchestra.saved: user.account' => [OnUpdateAccount::class],
    ];

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
     * Boot extension components.
     *
     * @return void
     */
    protected function bootExtensionComponents()
    {
        $path = realpath(__DIR__.'/../resources');

        $this->addConfigComponent('orchestra/control', 'orchestra/control', "{$path}/config");
        $this->addLanguageComponent('orchestra/control', 'orchestra/control', "{$path}/lang");
        $this->addViewComponent('orchestra/control', 'orchestra/control', "{$path}/views");

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
        $path = realpath(__DIR__.'/../');

        $this->loadBackendRoutesFrom("{$path}/routes/backend.php");
    }
}
