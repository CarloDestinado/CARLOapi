<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $medicalRecords = MedicalRecord::with(['patient.user', 'doctor.user'])->get();
        return response()->json($medicalRecords);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:users,id',
            'record_date' => 'required|date',
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
            'notes' => 'string|nullable',
            'prescription' => 'string|nullable'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $medicalRecord = MedicalRecord::create($request->all());

        return response()->json([
            'message' => 'Medical record created successfully',
            'medical_record' => $medicalRecord->load(['patient.user', 'doctor.user'])
        ], 201);
    }

    public function show($id)
    {
        $medicalRecord = MedicalRecord::with(['patient.user', 'doctor.user'])->find($id);
        
        if (!$medicalRecord) {
            return response()->json(['message' => 'Medical record not found'], 404);
        }

        return response()->json($medicalRecord);
    }

    public function update(Request $request, $id)
    {
        $medicalRecord = MedicalRecord::find($id);
        
        if (!$medicalRecord) {
            return response()->json(['message' => 'Medical record not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'patient_id' => 'exists:users,id',
            'doctor_id' => 'exists:users,id',
            'record_date' => 'date',
            'diagnosis' => 'string',
            'treatment' => 'string',
            'notes' => 'string|nullable',
            'prescription' => 'string|nullable'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $medicalRecord->update($request->all());

        return response()->json([
            'message' => 'Medical record updated successfully',
            'medical_record' => $medicalRecord->load(['patient.user', 'doctor.user'])
        ]);
    }

    public function destroy($id)
    {
        $medicalRecord = MedicalRecord::find($id);
        
        if (!$medicalRecord) {
            return response()->json(['message' => 'Medical record not found'], 404);
        }

        $medicalRecord->delete();

        return response()->json([
            'message' => 'Medical record deleted successfully'
        ]);
    }

    public function getPatientRecords($patientId)
    {
        $patient = User::find($patientId);
        
        if (!$patient || $patient->role !== 'patient') {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        $medicalRecords = MedicalRecord::with(['doctor.user'])
            ->where('patient_id', $patientId)
            ->get();

        return response()->json($medicalRecords);
    }
}