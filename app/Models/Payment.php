<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'appointment_id',
        'amount',
        'transaction_id',
        'status',
        'currency',
        'payment_method',
        'description'
    ];
    
    protected $casts = [
        'amount' => 'decimal:2',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
