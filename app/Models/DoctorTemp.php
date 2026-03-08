<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'clinic_id',
        'specialization_id',
        'clinic_address',
        'license_number',
        'bio',
        'session_price',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class, 'doctor_id');
    }
    public function clinic(): BelongsTo
    {
        return $this->belongsTo(clinic::class);
    }

    public function specialization(): BelongsTo
    {
        return $this->belongsTo(specialization::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(review::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(favorite::class);
    }

    public function availabilitySlots(): HasMany
    {
        return $this->hasMany(availability_slot::class);
    }
}
