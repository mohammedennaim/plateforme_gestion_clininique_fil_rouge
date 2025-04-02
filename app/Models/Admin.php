<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function doctor()
    {
        return $this->hasMany(Doctor::class);
    }
    public function patient()
    {
        return $this->hasMany(Patient::class);
    }
    // public function appointments()
    // {
    //     return $this->hasMany(Appointment::class);
    // }
    
    // public function prescriptions()
    // {
    //     return $this->hasMany(Prescription::class);
    // }
    // public function medicalRecords()
    // {
    //     return $this->hasMany(MedicalRecord::class);
    // }
    // public function medicalHistory()
    // {
    //     return $this->hasMany(MedicalHistory::class);
    // }

}
