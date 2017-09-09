<?php

declare(strict_types=1);

namespace Cortex\Attributable\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Cortex\Attributable\Console\Commands\SeedCommand;
use Cortex\Attributable\Console\Commands\InstallCommand;
use Cortex\Attributable\Console\Commands\MigrateCommand;
use Cortex\Attributable\Console\Commands\PublishCommand;
use Rinvex\Attributes\Contracts\AttributeContract;

class AttributableServiceProvider extends ServiceProvider
{
    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        MigrateCommand::class => 'command.cortex.attributable.migrate',
        PublishCommand::class => 'command.cortex.attributable.publish',
        InstallCommand::class => 'command.cortex.attributable.install',
        SeedCommand::class => 'command.cortex.attributable.seed',
    ];

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register()
    {
        // Register console commands
        ! $this->app->runningInConsole() || $this->registerCommands();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        // Bind route models and constrains
        $router->pattern('attribute', '[a-z0-9-]+');
        $router->model('attribute', AttributeContract::class);

        // Load resources
        require __DIR__.'/../../routes/breadcrumbs.php';
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'cortex/attributable');
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'cortex/attributable');
        $this->app->afterResolving('blade.compiler', function () {
            require __DIR__.'/../../routes/menus.php';
        });

        // Publish Resources
        ! $this->app->runningInConsole() || $this->publishResources();
    }

    /**
     * Publish resources.
     *
     * @return void
     */
    protected function publishResources()
    {
        $this->publishes([realpath(__DIR__.'/../../resources/lang') => resource_path('lang/vendor/cortex/attributable')], 'cortex-attributable-lang');
        $this->publishes([realpath(__DIR__.'/../../resources/views') => resource_path('views/vendor/cortex/attributable')], 'cortex-attributable-views');
    }

    /**
     * Register console commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        // Register artisan commands
        foreach ($this->commands as $key => $value) {
            $this->app->singleton($value, function ($app) use ($key) {
                return new $key();
            });
        }

        $this->commands(array_values($this->commands));
    }
}
