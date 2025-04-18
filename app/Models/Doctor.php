<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $table = 'doctors';
    
    protected $fillable = [
        'user_id',
        'speciality',
        'experience',
        'qualification',
        'is_available',
        'nombre_cabinet',
        'working_hours',
        'consultation_fee',
        
    ];
    protected $casts = [
        'is_available' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    
    /**
     * Get the medical records created by the doctor
     */
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }

    public function getFullNameAttribute()
    {
        return $this->user->name;
    }

    public function getEmailAttribute()
    {
        return $this->user->email;
    }

    public function getPhoneAttribute()
    {
        return $this->user->phone;
    }
    public function speciality()
    {
        return $this->belongsTo(Speciality::class, 'id_speciality');
    }
}
