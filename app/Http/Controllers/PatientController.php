<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    public function index()
    {
        $patients = User::where('role', 'patient')->with('patient')->get();
        return response()->json($patients);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:male,female,other',
            'address' => 'required|string',
            'phone_number' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'patient'
        ]);

        $patient = Patient::create([
            'user_id' => $user->id,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'blood_type' => $request->blood_type,
            'height' => $request->height,
            'weight' => $request->weight,
            'allergies' => $request->allergies,
            'medical_history' => $request->medical_history
        ]);

        return response()->json([
            'message' => 'Patient created successfully',
            'patient' => $user->load('patient')
        ], 201);
    }

    public function show($id)
    {
        $patient = User::with('patient')->find($id);
        
        if (!$patient || $patient->role !== 'patient') {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        return response()->json($patient);
    }

    public function update(Request $request, $id)
    {
        $patient = User::with('patient')->find($id);
        
        if (!$patient || $patient->role !== 'patient') {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,'.$id,
            'date_of_birth' => 'date',
            'gender' => 'string|in:male,female,other',
            'address' => 'string',
            'phone_number' => 'string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $patient->update($request->only(['name', 'email']));

        if ($patient->patient) {
            $patient->patient->update($request->except(['name', 'email', 'password']));
        }

        return response()->json([
            'message' => 'Patient updated successfully',
            'patient' => $patient->load('patient')
        ]);
    }

    public function destroy($id)
    {
        $patient = User::find($id);
        
        if (!$patient || $patient->role !== 'patient') {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        if ($patient->patient) {
            $patient->patient->delete();
        }

        $patient->delete();

        return response()->json([
            'message' => 'Patient deleted successfully'
        ]);
    }
}