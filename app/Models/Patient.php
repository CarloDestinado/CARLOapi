<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'address',
        'city',
        'state',
        'postal_code',
        'phone',
        'email',
        'emergency_contact_name',
        'emergency_contact_phone',
        'blood_type',
        'allergies'
    ];

    // Relationships
    public function diagnoses()
    {
        return $this->hasMany(Diagnosis::class);
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }
}