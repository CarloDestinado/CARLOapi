<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'record_date',
        'record_type',
        'title',
        'description',
        'findings',
        'is_confidential',
        'created_by'
    ];

    // Relationships
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function diagnoses()
    {
        return $this->belongsToMany(Diagnosis::class);
    }
}