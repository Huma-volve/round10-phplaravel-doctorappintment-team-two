<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'user_id',
        'clinic_id',
        'specialization_id',
        'clinic_address',
        'license_number',
        'session_price',
        'bio',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class, 'doctor_id');
    }
}
