<?php

declare(strict_types=1);

namespace Cortex\Attributable\Console\Commands;

use Rinvex\Attributes\Console\Commands\MigrateCommand as BaseMigrateCommand;

class MigrateCommand extends BaseMigrateCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:migrate:attributable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Cortex Attributable Tables.';
}
