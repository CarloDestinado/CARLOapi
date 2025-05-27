<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        return Patient::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|unique:patients',
            'first_name' => 'required',
            'last_name' => 'required',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other'
        ]);

        $patient = Patient::create($validated);

        return response()->json($patient, 201);
    }

    public function show(Patient $patient)
    {
        return $patient;
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'phone' => 'sometimes|required',
            'address' => 'sometimes|required'
        ]);

        $patient->update($validated);

        return response()->json($patient);
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return response()->json(null, 204);
    }
}