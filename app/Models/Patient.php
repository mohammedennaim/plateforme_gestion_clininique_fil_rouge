<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name_assurance',
        'assurance_number',
        'blood_type',
        'emergency_contact',
        'medical_history',
        'height',
        'weight',
    ];

    protected $casts = [
        'last_visit_date' => 'datetime',
        'medical_history' => 'array',
        'allergies' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function getFullNameAttribute(): string
    {
        return $this->user->name;
    }

    public function getEmailAttribute(): string
    {
        return $this->user->email;
    }

    public function getPhoneAttribute(): string
    {
        return $this->user->phone;
    }

    public function getAddressAttribute(): string
    {
        return $this->user->adresse;
    }

    public function getAgeAttribute(): int
    {
        return $this->user->date_of_birth ? now()->diffInYears($this->user->date_of_birth) : 0;
    }

    public function getBmiAttribute(): ?float
    {
        if (!$this->height || !$this->weight) {
            return null;
        }
        
        $heightInMeters = $this->height / 100;
        return round($this->weight / ($heightInMeters * $heightInMeters), 2);
    }

    public function getBmiCategoryAttribute(): string
    {
        $bmi = $this->bmi;
        
        if ($bmi === null) {
            return 'Non disponible';
        }
        
        if ($bmi < 18.5) {
            return 'Insuffisance pondérale';
        } elseif ($bmi < 25) {
            return 'Poids normal';
        } elseif ($bmi < 30) {
            return 'Surpoids';
        } else {
            return 'Obésité';
        }
    }

    public function scopeWithInsurance($query)
    {
        return $query->whereNotNull('name_assurance')
                    ->whereNotNull('assurance_number');
    }

    public function scopeWithoutInsurance($query)
    {
        return $query->whereNull('name_assurance')
                    ->orWhereNull('assurance_number');
    }

    public function scopeWithBloodType($query, string $bloodType)
    {
        return $query->where('blood_type', $bloodType);
    }

    public function scopeActive($query)
    {
        return $query->whereHas('user', function ($query) {
            $query->where('status', 'active');
        });
    }
}
