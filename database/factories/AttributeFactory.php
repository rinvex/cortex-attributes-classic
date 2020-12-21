<?php

declare(strict_types=1);

namespace Cortex\Attributes\Database\Factories;

use Cortex\Attributes\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Attribute::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'slug' => $this->faker->slug,
            'type' => $this->faker->randomElement(['boolean', 'datetime', 'integer', 'text', 'varchar']),
            'name' => $this->faker->name,
            'entities' => $this->faker->randomElement(['App\Models\Company', 'App\Models\Product', 'App\Models\User']),
        ];
    }
}
