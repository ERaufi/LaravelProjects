<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Countries>
 */
class CountriesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    private static int $index = 0;

    public function definition(): array
    {
        return [
            'name' => $this->faker->country,
            'order_number' => ++static::$index,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
