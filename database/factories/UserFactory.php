<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password123'),
            'role' => $this->faker->randomElement(['doctor', 'nurse', 'admin']),
            'phone' => $this->faker->phoneNumber(),
            'license_number' => 'MD'.$this->faker->unique()->numberBetween(100000, 999999),
            'specialization' => $this->faker->randomElement(['Cardiology', 'Neurology', 'Pediatrics']),
            'remember_token' => Str::random(10),
        ];
    }
}