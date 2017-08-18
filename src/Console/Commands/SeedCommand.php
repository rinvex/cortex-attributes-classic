<?php

declare(strict_types=1);

namespace Cortex\Attributable\Console\Commands;

use Illuminate\Console\Command;
use Rinvex\Fort\Traits\AbilitySeeder;
use Rinvex\Fort\Traits\ArtisanHelper;
use Illuminate\Support\Facades\Schema;

class SeedCommand extends Command
{
    use AbilitySeeder;
    use ArtisanHelper;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:seed:attributable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed Default Cortex Attributable data.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->warn('Seed cortex/attributable:');

        if ($this->ensureExistingAttributableTables()) {
            // No seed data at the moment!
        }

        if ($this->ensureExistingFortTables()) {
            $this->seedAbilities(realpath(__DIR__.'/../../../resources/data/abilities.json'));
        }
    }

    /**
     * Ensure existing attributable tables.
     *
     * @return bool
     */
    protected function ensureExistingAttributableTables()
    {
        if (! $this->hasAttributableTables()) {
            $this->call('cortex:migrate:attributable');
        }

        return true;
    }

    /**
     * Check if all required attributable tables exists.
     *
     * @return bool
     */
    protected function hasAttributableTables()
    {
        return Schema::hasTable(config('rinvex.attributable.tables.attributes'))
               && Schema::hasTable(config('rinvex.attributable.tables.attribute_entity'))
               && Schema::hasTable(config('rinvex.attributable.tables.attribute_boolean_values'))
               && Schema::hasTable(config('rinvex.attributable.tables.attribute_datetime_values'))
               && Schema::hasTable(config('rinvex.attributable.tables.attribute_integer_values'))
               && Schema::hasTable(config('rinvex.attributable.tables.attribute_text_values'))
               && Schema::hasTable(config('rinvex.attributable.tables.attribute_varchar_values'));
    }
}
