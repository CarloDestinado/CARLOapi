<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\PatientController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // User management routes
    Route::get('/get-users', [UserController::class, 'getAllUsers']);
    Route::post('/add-user', [UserController::class, 'addUser']);
    Route::put('/edit-user/{id}', [UserController::class, 'editUser']);
    Route::delete('/delete-user/{id}', [UserController::class, 'deleteUser']);
    
    // Patient routes
    Route::get('/patients', [PatientController::class, 'index']);
    Route::post('/patients', [PatientController::class, 'store']);
    Route::get('/patients/{id}', [PatientController::class, 'show']);
    Route::put('/patients/{id}', [PatientController::class, 'update']);
    Route::delete('/patients/{id}', [PatientController::class, 'destroy']);
    
    // Diagnosis history routes
    Route::get('/diagnoses', [DiagnosisController::class, 'index']);
    Route::post('/diagnoses', [DiagnosisController::class, 'store']);
    Route::get('/diagnoses/{id}', [DiagnosisController::class, 'show']);
    Route::put('/diagnoses/{id}', [DiagnosisController::class, 'update']);
    Route::delete('/diagnoses/{id}', [DiagnosisController::class, 'destroy']);
    Route::get('/patients/{patientId}/diagnoses', [DiagnosisController::class, 'getPatientDiagnoses']);
    
    // Medical records routes
    Route::get('/medical-records', [MedicalRecordController::class, 'index']);
    Route::post('/medical-records', [MedicalRecordController::class, 'store']);
    Route::get('/medical-records/{id}', [MedicalRecordController::class, 'show']);
    Route::put('/medical-records/{id}', [MedicalRecordController::class, 'update']);
    Route::delete('/medical-records/{id}', [MedicalRecordController::class, 'destroy']);
    Route::get('/patients/{patientId}/medical-records', [MedicalRecordController::class, 'getPatientRecords']);
    
    // Logout
    Route::post('/logout', [AuthenticationController::class, 'logout']);
});