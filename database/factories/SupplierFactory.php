<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() : array
    {
        return [
            'CORPORATE_NAME' => $this->faker->company(),
            'TRADE_NAME' => $this->faker->firstName(),
            'CNPJ' => $this->faker->cnpj(false),
            'EMAIL' => $this->faker->companyEmail(),
            'COMMERCIAL_PHONE' => $this->faker->phoneNumber(),
            'ADDRESS_ID' => Address::factory()
        ];
    }
}