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
    protected $signature = 'cortex:publish:attributes';

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
        $this->call('vendor:publish', ['--tag' => 'rinvex-attributes-config']);
        $this->call('vendor:publish', ['--tag' => 'cortex-attributes-views']);
        $this->call('vendor:publish', ['--tag' => 'cortex-attributes-lang']);
    }
}
