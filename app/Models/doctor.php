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
<<<<<<< HEAD
=======
        return $this->hasMany(Chat::class, 'doctor_id');
    }
    public function clinic(): BelongsTo
    {
>>>>>>> 09621b2ad9c9f16f2bd78156f87a0655c864e7b3
        return $this->belongsTo(Clinic::class);
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    public function reviews()
    {
<<<<<<< HEAD
        return $this->hasMany(Review::class, 'doctor_id');
=======
        return $this->hasMany(Review::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function availabilitySlots(): HasMany
    {
        return $this->hasMany(AvailabilitySlot::class);
>>>>>>> 09621b2ad9c9f16f2bd78156f87a0655c864e7b3
    }
}
