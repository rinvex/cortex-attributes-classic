<?php

declare(strict_types=1);

namespace Cortex\Attributes\Providers;

use Cortex\Attributes\Console\Commands\ActivateCommand;
use Cortex\Attributes\Console\Commands\AutoloadCommand;
use Cortex\Attributes\Console\Commands\DeactivateCommand;
use Cortex\Attributes\Console\Commands\UnloadCommand;
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
        ActivateCommand::class => 'command.cortex.attributes.activate',
        DeactivateCommand::class => 'command.cortex.attributes.deactivate',
        AutoloadCommand::class => 'command.cortex.attributes.autoload',
        UnloadCommand::class => 'command.cortex.attributes.unload',

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
        $this->registerCommands($this->commands);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Router $router, Dispatcher $dispatcher): void
    {
        // Bind route models and constrains
        $router->pattern('attribute', '[a-zA-Z0-9-_]+');
        $router->model('attribute', config('rinvex.attributes.models.attribute'));

        // Map relations
        Relation::morphMap([
            'attribute' => config('rinvex.attributes.models.attribute'),
        ]);

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
                return "<?php echo {$expression}->getEntityAttributes()->map->render({$expression}, app('request.accessarea'))->implode('') ?: view('cortex/attributes::".app('request.accessarea').".partials.no-results'); ?>";
            });
        });
    }
}
