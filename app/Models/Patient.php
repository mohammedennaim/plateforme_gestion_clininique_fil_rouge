<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name_assurance',
        'assurance_number',
        'blood_type',
        'emergency_contact',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
