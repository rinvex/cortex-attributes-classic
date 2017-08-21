<?php

declare(strict_types=1);

namespace Cortex\Attributable\Console\Commands;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:publish:attributable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish Cortex Attributable Resources.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->warn('Publish cortex/attributable:');
        $this->call('vendor:publish', ['--tag' => 'rinvex-attributable-config']);
        $this->call('vendor:publish', ['--tag' => 'cortex-attributable-views']);
        $this->call('vendor:publish', ['--tag' => 'cortex-attributable-lang']);
    }
}
