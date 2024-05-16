<?php

namespace Database\Factories;

use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductTransaction>
 */
class ProductTransactionsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $productIds = Products::pluck('id')->toArray();

        return [
            'product_id' => $this->faker->randomElement($productIds),
            'transaction_type' => $this->faker->randomElement(['buy', 'sell']),
            'quantity' => $this->faker->numberBetween(1, 50),
            'price' => $this->faker->numberBetween(10, 100), // Assuming price range from 10 to 100
            'total_price' => function (array $attributes) {
                return $attributes['quantity'] * $attributes['price'];
            },
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
