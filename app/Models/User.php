<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'phone',
        'license_number',
        'specialization'
    ];

    protected $hidden = ['password'];

    // Relationships
    public function diagnoses()
    {
        return $this->hasMany(Diagnosis::class, 'doctor_id');
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class, 'created_by');
    }
}