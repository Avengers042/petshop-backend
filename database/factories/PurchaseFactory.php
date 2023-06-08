<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ShoppingCart;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchase>
 */
class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() : array
    {
        return [
            'AMOUNT' => $this->faker->numberBetween(1, 100),
            'SHOPPING_CART_ID' => ShoppingCart::factory(),
            'PRODUCT_ID' => Product::factory(),
            'USER_ID' => User::factory(),
        ];
    }
}
