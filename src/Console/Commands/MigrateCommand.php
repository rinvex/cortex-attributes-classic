<?php

declare(strict_types=1);

namespace Cortex\Attributes\Console\Commands;

use Rinvex\Attributes\Console\Commands\MigrateCommand as BaseMigrateCommand;

class MigrateCommand extends BaseMigrateCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:migrate:attributes {--force : Force the operation to run when in production.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Cortex Attributes Tables.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        parent::handle();

        $this->call('migrate', ['--step' => true, '--path' => 'app/cortex/attributes/database/migrations', '--force' => $this->option('force')]);
    }
}
