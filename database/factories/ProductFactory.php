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
            'name'=> fake()->word(2,true),
            'description'=> fake()->text(),
            'price'=> fake()->randomFloat(2, 1, 100),
            'stock'=> fake()->randomNumber(2),
            'image'=> fake()->imageUrl(600, 600),
            //
        ];
    }
}
