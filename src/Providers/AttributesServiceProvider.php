<?php

declare(strict_types=1);

namespace Cortex\Attributes\Providers;

use Illuminate\Routing\Router;
use Cortex\Attributes\Models\Attribute;
use Illuminate\Support\ServiceProvider;
use Rinvex\Support\Traits\ConsoleTools;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\View\Compilers\BladeCompiler;
use Cortex\Attributes\Console\Commands\SeedCommand;
use Illuminate\Database\Eloquent\Relations\Relation;
use Cortex\Attributes\Console\Commands\InstallCommand;
use Cortex\Attributes\Console\Commands\MigrateCommand;
use Cortex\Attributes\Console\Commands\PublishCommand;
use Cortex\Attributes\Console\Commands\RollbackCommand;

class AttributesServiceProvider extends ServiceProvider
{
    use ConsoleTools;

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        SeedCommand::class => 'command.cortex.attributes.seed',
        InstallCommand::class => 'command.cortex.attributes.install',
        MigrateCommand::class => 'command.cortex.attributes.migrate',
        PublishCommand::class => 'command.cortex.attributes.publish',
        RollbackCommand::class => 'command.cortex.attributes.rollback',
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
    public function register(): void
    {
        // Bind eloquent models to IoC container
        $this->app['config']['rinvex.attributes.models.attribute'] === Attribute::class
        || $this->app->alias('rinvex.attributes.attribute', Attribute::class);

        // Register console commands
        ! $this->app->runningInConsole() || $this->registerCommands();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Router $router, Dispatcher $dispatcher): void
    {
        // Bind route models and constrains
        $router->pattern('attribute', '[a-zA-Z0-9-]+');
        $router->model('attribute', config('rinvex.attributes.models.attribute'));

        // Map relations
        Relation::morphMap([
            'attribute' => config('rinvex.attributes.models.attribute'),
        ]);

        // Load resources
        $this->loadRoutesFrom(__DIR__.'/../../routes/web/adminarea.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'cortex/attributes');
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'cortex/attributes');

        $this->app->runningInConsole() || $dispatcher->listen('accessarea.ready', function ($accessarea) {
            ! file_exists($menus = __DIR__."/../../routes/menus/{$accessarea}.php") || require $menus;
            ! file_exists($breadcrumbs = __DIR__."/../../routes/breadcrumbs/{$accessarea}.php") || require $breadcrumbs;
        });

        // Add default attributes types
        Attribute::typeMap([
            'integer' => \Rinvex\Attributes\Models\Type\Integer::class,
            'boolean' => \Rinvex\Attributes\Models\Type\Boolean::class,
            'select' => \Rinvex\Attributes\Models\Type\Varchar::class,
            'textarea' => \Rinvex\Attributes\Models\Type\Text::class,
            'radio' => \Rinvex\Attributes\Models\Type\Varchar::class,
            'check' => \Rinvex\Attributes\Models\Type\Varchar::class,
            'text' => \Rinvex\Attributes\Models\Type\Varchar::class,
        ]);

        // Register blade extensions
        $this->registerBladeExtensions();

        // Publish Resources
        ! $this->app->runningInConsole() || $this->publishesLang('cortex/attributes', true);
        ! $this->app->runningInConsole() || $this->publishesViews('cortex/attributes', true);
        ! $this->app->runningInConsole() || $this->publishesMigrations('cortex/attributes', true);
    }

    /**
     * Register the blade extensions.
     *
     * @return void
     */
    protected function registerBladeExtensions(): void
    {
        $this->app->afterResolving('blade.compiler', function (BladeCompiler $bladeCompiler) {
            // @attributes($entity)
            $bladeCompiler->directive('attributes', function ($expression) {
                return "<?php echo {$expression}->getEntityAttributes()->map->render({$expression}, request()->route('accessarea'))->implode('') ?: view('cortex/attributes::".request()->route('accessarea').".partials.no-results'); ?>";
            });
        });
    }
}
