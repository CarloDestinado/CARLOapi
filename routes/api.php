<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Base URL: /api (Laravel automatically prefixes 'api')

// Authentication
Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout')->middleware('auth:sanctum');

// User Management
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/get-users', 'UserController@index');
    Route::post('/add-user', 'UserController@store');
    Route::put('/edit-user/{id}', 'UserController@update');
    Route::delete('/delete-user/{id}', 'UserController@destroy');
});

// Patient Management
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/patients', 'PatientController@index');
    Route::post('/patients', 'PatientController@store');
    Route::get('/patients/{id}', 'PatientController@show');
    Route::put('/patients/{id}', 'PatientController@update');
    Route::delete('/patients/{id}', 'PatientController@destroy');
});

// Diagnosis Management
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/diagnoses', 'DiagnosisController@index');
    Route::post('/diagnoses', 'DiagnosisController@store');
    Route::get('/diagnoses/{id}', 'DiagnosisController@show');
    Route::put('/diagnoses/{id}', 'DiagnosisController@update');
    Route::delete('/diagnoses/{id}', 'DiagnosisController@destroy');
    Route::get('/patients/{id}/diagnoses', 'DiagnosisController@patientDiagnoses');
});

// Medical Records
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/medical-records', 'MedicalRecordController@index');
    Route::post('/medical-records', 'MedicalRecordController@store');
    Route::get('/medical-records/{id}', 'MedicalRecordController@show');
    Route::put('/medical-records/{id}', 'MedicalRecordController@update');
    Route::delete('/medical-records/{id}', 'MedicalRecordController@destroy');
    Route::get('/patients/{id}/medical-records', 'MedicalRecordController@patientRecords');
});