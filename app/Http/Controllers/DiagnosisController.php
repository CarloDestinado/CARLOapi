<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiagnosisController extends Controller
{
    public function index()
    {
        $diagnoses = Diagnosis::with(['patient.user', 'doctor.user'])->get();
        return response()->json($diagnoses);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:users,id',
            'diagnosis_date' => 'required|date',
            'symptoms' => 'required|string',
            'diagnosis' => 'required|string',
            'treatment_plan' => 'string|nullable',
            'notes' => 'string|nullable'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $diagnosis = Diagnosis::create($request->all());

        return response()->json([
            'message' => 'Diagnosis created successfully',
            'diagnosis' => $diagnosis->load(['patient.user', 'doctor.user'])
        ], 201);
    }

    public function show($id)
    {
        $diagnosis = Diagnosis::with(['patient.user', 'doctor.user'])->find($id);
        
        if (!$diagnosis) {
            return response()->json(['message' => 'Diagnosis not found'], 404);
        }

        return response()->json($diagnosis);
    }

    public function update(Request $request, $id)
    {
        $diagnosis = Diagnosis::find($id);
        
        if (!$diagnosis) {
            return response()->json(['message' => 'Diagnosis not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'patient_id' => 'exists:users,id',
            'doctor_id' => 'exists:users,id',
            'diagnosis_date' => 'date',
            'symptoms' => 'string',
            'diagnosis' => 'string',
            'treatment_plan' => 'string|nullable',
            'notes' => 'string|nullable'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $diagnosis->update($request->all());

        return response()->json([
            'message' => 'Diagnosis updated successfully',
            'diagnosis' => $diagnosis->load(['patient.user', 'doctor.user'])
        ]);
    }

    public function destroy($id)
    {
        $diagnosis = Diagnosis::find($id);
        
        if (!$diagnosis) {
            return response()->json(['message' => 'Diagnosis not found'], 404);
        }

        $diagnosis->delete();

        return response()->json([
            'message' => 'Diagnosis deleted successfully'
        ]);
    }

    public function getPatientDiagnoses($patientId)
    {
        $patient = User::find($patientId);
        
        if (!$patient || $patient->role !== 'patient') {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        $diagnoses = Diagnosis::with(['doctor.user'])
            ->where('patient_id', $patientId)
            ->get();

        return response()->json($diagnoses);
    }
}