<?php

declare(strict_types=1);

use Illuminate\Database\Seeder;

class CortexAttributesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $abilities = [
            ['name' => 'list', 'title' => 'List attributes', 'entity_type' => 'attribute'],
            ['name' => 'import', 'title' => 'Import attributes', 'entity_type' => 'attribute'],
            ['name' => 'create', 'title' => 'Create attributes', 'entity_type' => 'attribute'],
            ['name' => 'update', 'title' => 'Update attributes', 'entity_type' => 'attribute'],
            ['name' => 'delete', 'title' => 'Delete attributes', 'entity_type' => 'attribute'],
            ['name' => 'audit', 'title' => 'Audit attributes', 'entity_type' => 'attribute'],
        ];

        collect($abilities)->each(function (array $ability) {
            app('cortex.auth.ability')->firstOrCreate([
                'name' => $ability['name'],
                'entity_type' => $ability['entity_type'],
            ], $ability);
        });
    }
}
