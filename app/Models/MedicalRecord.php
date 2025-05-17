<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'record_date',
        'diagnosis',
        'treatment',
        'notes',
        'prescription'
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class);
    }

    public function getFormattedRecordDateAttribute()
    {
        return $this->record_date->format('F j, Y');
    }

    public function getPrescriptionArrayAttribute()
    {
        if (empty($this->prescription)) {
            return [];
        }
        
        return json_decode($this->prescription, true);
    }
}