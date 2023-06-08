<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Image;
use App\Models\Supplier;
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
    public function definition() : array
    {
        return [
            'NAME' => $this->faker->firstName(),
            'DESCRIPTION' => $this->faker->paragraph(),
            'PRICE' => $this->faker->randomNumber(2),
            'SUPPLIER_ID' => Supplier::factory(),
            'IMAGE_ID' => Image::factory(),
            'CATEGORY_ID' => Category::factory()
        ];
    }
}
