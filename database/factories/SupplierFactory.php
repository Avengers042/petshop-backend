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
        $commercialPhone = intval(str_replace('-', '', $this->faker->cellphone()));

        return [
            'CORPORATE_NAME' => $this->faker->company(),
            'TRADE_NAME' => $this->faker->firstName(),
            'CNPJ' => $this->faker->cnpj(false),
            'EMAIL' => $this->faker->companyEmail(),
            'COMMERCIAL_PHONE' => $commercialPhone,
            'ADDRESS_ID' => Address::factory()
        ];
    }
}