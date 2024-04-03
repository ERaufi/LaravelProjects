<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'quantity' => $this->faker->numberBetween(1, 100),
            'buyingPrice' => $this->faker->randomFloat(2, 1, 1000),
            'sellingPrice' => $this->faker->randomFloat(2, 1, 2000),
            'description' => $this->faker->paragraph,
            // 'image_url' => $this->faker->image(public_path('productsImage'), 640, 480, null, false),
            'image_url' => $this->faker->word,
            'weight' => $this->faker->randomFloat(2, 0.1, 50),
        ];
    }
}
