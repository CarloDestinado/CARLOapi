<?php

namespace Database\Seeders;

use App\Models\Diagnosis;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;

class MedicalRecordSeeder extends Seeder
{
    public function run()
    {
        $patients = Patient::all();
        $staff = User::all();

        foreach ($patients as $patient) {
            $records = MedicalRecord::factory()->count(rand(2, 8))->create([
                'patient_id' => $patient->id,
                'created_by' => $staff->random()->id,
            ]);

            // Attach diagnoses to records
            foreach ($records as $record) {
                $diagnoses = Diagnosis::where('patient_id', $patient->id)
                    ->inRandomOrder()
                    ->limit(rand(1, 3))
                    ->get();
                
                $record->diagnoses()->attach($diagnoses);
            }
        }
    }
}