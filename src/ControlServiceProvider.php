<?php namespace Orchestra\Control;

use Orchestra\Control\Command\Synchronizer;
use Orchestra\Support\Providers\ServiceProvider;
use Orchestra\Control\Http\Handlers\ControlMenuHandler;
use Orchestra\Control\Listeners\Timezone\OnShowAccount;
use Orchestra\Control\Listeners\Timezone\OnUpdateAccount;
use Orchestra\Support\Providers\Traits\EventProviderTrait;
use Orchestra\Control\Listeners\Configuration\OnShowConfiguration;
use Orchestra\Control\Listeners\Configuration\OnUpdateConfiguration;
use Orchestra\Control\Contracts\Command\Synchronizer as SynchronizerContract;

class ControlServiceProvider extends ServiceProvider
{
    use EventProviderTrait;

    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'orchestra.ready: admin'                       => [ControlMenuHandler::class],
        'orchestra.form: extension.orchestra/control'  => [OnShowConfiguration::class],
        'orchestra.saved: extension.orchestra/control' => [OnUpdateConfiguration::class],
        'orchestra.form: user.account'                 => [OnShowAccount::class],
        'orchestra.saved: user.account'                => [OnUpdateAccount::class],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [];

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

        $this->registerEventListeners($this->app->make('events'));

        $this->mapExtensionConfig();

        if (! $this->app->routesAreCached()) {
            require "{$path}/src/routes.php";
        }
    }

    /**
     * Map extension config.
     *
     * @return void
     */
    protected function mapExtensionConfig()
    {
        $this->app->make('orchestra.extension.config')->map('orchestra/control', [
            'localtime'   => 'orchestra/control::localtime.enable',
            'admin_role'  => 'orchestra/foundation::roles.admin',
            'member_role' => 'orchestra/foundation::roles.member',
        ]);
    }
}
