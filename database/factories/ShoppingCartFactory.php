<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ShoppingCartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $number = 1;

        return [
            'SHOPPING_CART_ID' => $number++
        ];
    }
}
