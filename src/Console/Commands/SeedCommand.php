<?php

declare(strict_types=1);

namespace Cortex\Attributes\Console\Commands;

use Illuminate\Console\Command;
use Cortex\Attributes\Database\Seeders\CortexAttributesSeeder;

class SeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:seed:attributes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed Cortex Attributes Data.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->alert($this->description);

        $this->call('db:seed', ['--class' => CortexAttributesSeeder::class]);

        $this->line('');
    }
}
