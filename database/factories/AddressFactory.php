<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() : array
    {
        $cep = str_replace('-', '', $this->faker->postcode());

        return [
            'NUMBER' => $this->faker->numberBetween(1, 1000),
            'CEP' => $cep,
            'UF' => "DF",
            'DISTRICT' => "Setor Leste (Gama)",
            'PUBLIC_PLACE' => $this->faker->streetAddress(),
        ];
    }
}