<?php

declare(strict_types=1);

namespace Cortex\Attributable\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:install:attributable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Cortex Attributable Module.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->warn('Install cortex/attributable:');
        $this->call('cortex:migrate:attributable');
        $this->call('cortex:seed:attributable');
        $this->call('cortex:publish:attributable');
    }
}
