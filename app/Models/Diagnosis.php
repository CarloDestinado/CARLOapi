<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'icd_code',
        'diagnosis_name',
        'description',
        'diagnosis_date',
        'status',
        'severity',
        'treatment_plan'
    ];

    // Relationships
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function medicalRecords()
    {
        return $this->belongsToMany(MedicalRecord::class);
    }
}