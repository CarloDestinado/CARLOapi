<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::factory()->create([
            'first_name' => 'Admin',
            'email' => 'admin@hospital.com',
            'role' => 'admin',
        ]);

        // Create 5 doctors
        User::factory()->count(5)->create([
            'role' => 'doctor'
        ]);

        // Create 10 nurses
        User::factory()->count(10)->create([
            'role' => 'nurse'
        ]);
    }
}