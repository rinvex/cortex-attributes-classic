<?php

declare(strict_types=1);

namespace Cortex\Attributes\Console\Commands;

use Rinvex\Attributes\Console\Commands\PublishCommand as BasePublishCommand;

class PublishCommand extends BasePublishCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:publish:attributes {--force : Overwrite any existing files.} {--R|resource=all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish Cortex Attributes Resources.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        parent::handle();

        switch ($this->option('resource')) {
            case 'lang':
                $this->call('vendor:publish', ['--tag' => 'cortex-addresses-lang', '--force' => $this->option('force')]);
                break;
            case 'views':
                $this->call('vendor:publish', ['--tag' => 'cortex-addresses-views', '--force' => $this->option('force')]);
                break;
            case 'migrations':
                $this->call('vendor:publish', ['--tag' => 'cortex-addresses-migrations', '--force' => $this->option('force')]);
                break;
            default:
                $this->call('vendor:publish', ['--tag' => 'cortex-addresses-lang', '--force' => $this->option('force')]);
                $this->call('vendor:publish', ['--tag' => 'cortex-addresses-views', '--force' => $this->option('force')]);
                $this->call('vendor:publish', ['--tag' => 'cortex-addresses-migrations', '--force' => $this->option('force')]);
                break;
        }

        $this->line('');
    }
}
