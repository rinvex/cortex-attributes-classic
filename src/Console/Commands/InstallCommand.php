<?php

declare(strict_types=1);

namespace Cortex\Attributes\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:install:attributes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Cortex Attributes Module.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->warn($this->description);

        $this->call('cortex:migrate:attributes');
        $this->call('cortex:seed:attributes');
        $this->call('cortex:publish:attributes');
    }
}
