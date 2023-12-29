<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->uuid(),
            'product_name' => fake()->name(),
            'description' => fake()->sentence(),
            'price' => fake()->numberBetween(2, 150),
            'status' => fake()->numberBetween(0, 2),
            'user_id' => fake()->numberBetween(1, 150),
        ];
    }
}
