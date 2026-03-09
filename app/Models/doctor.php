<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Doctor extends Model
{
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'doctor_id');
    }
}
