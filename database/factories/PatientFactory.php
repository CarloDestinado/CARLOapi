<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    public function definition()
    {
        return [
            'patient_id' => 'PT'.$this->faker->unique()->numberBetween(1000, 9999),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'date_of_birth' => $this->faker->dateTimeBetween('-70 years', '-18 years'),
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'postal_code' => $this->faker->postcode(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'emergency_contact_name' => $this->faker->name(),
            'emergency_contact_phone' => $this->faker->phoneNumber(),
            'blood_type' => $this->faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
            'allergies' => $this->faker->randomElement(['Penicillin', 'Peanuts', 'Dust', 'None']),
        ];
    }
}