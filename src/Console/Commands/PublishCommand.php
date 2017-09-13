<?php

declare(strict_types=1);

namespace Cortex\Attributes\Console\Commands;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:publish:attributes {--force : Overwrite any existing files.}';

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
    public function handle()
    {
        $this->warn('Publish cortex/attributes:');
        $this->call('vendor:publish', ['--tag' => 'rinvex-attributes-config', '--force' => $this->option('force')]);
        $this->call('vendor:publish', ['--tag' => 'cortex-attributes-views', '--force' => $this->option('force')]);
        $this->call('vendor:publish', ['--tag' => 'cortex-attributes-lang', '--force' => $this->option('force')]);
    }
}
