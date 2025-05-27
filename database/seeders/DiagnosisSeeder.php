<?php

namespace Database\Seeders;

use App\Models\Diagnosis;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;

class DiagnosisSeeder extends Seeder
{
    public function run()
    {
        $patients = Patient::all();
        $doctors = User::where('role', 'doctor')->get();

        foreach ($patients as $patient) {
            Diagnosis::factory()->count(rand(1, 5))->create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctors->random()->id,
            ]);
        }
    }
}