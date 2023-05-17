<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() : array
    {
        return [
            'FIRST_NAME' => $this->faker->firstName(),
            'LAST_NAME' => $this->faker->lastName(),
            'CPF' => $this->faker->cpf(false),
            'EMAIL' => $this->faker->safeEmail(),
            'AGE' => $this->faker->numberBetween(18, 100),
            'PASSWORD' => $this->faker->password(),
            'PASSWORD' => Hash::make($this->faker->password()),
            'ADDRESS_ID' => Address::factory()
        ];
    }
}
