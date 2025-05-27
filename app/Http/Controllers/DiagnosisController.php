<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use App\Models\Patient;
use Illuminate\Http\Request;

class DiagnosisController extends Controller
{
    public function index()
    {
        return Diagnosis::with(['patient', 'doctor'])->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'icd_code' => 'required',
            'diagnosis_name' => 'required',
            'status' => 'required|in:active,chronic,resolved'
        ]);

        $validated['doctor_id'] = auth()->id();

        $diagnosis = Diagnosis::create($validated);

        return response()->json($diagnosis, 201);
    }

    public function patientDiagnoses(Patient $patient)
    {
        return $patient->diagnoses()->with('doctor')->get();
    }
}