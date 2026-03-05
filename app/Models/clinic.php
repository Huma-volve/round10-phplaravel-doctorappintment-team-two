<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class clinic extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_clinic',
        'phone',
        'address',
        'latitude',
        'longitude',
    ];

    public function doctors(): HasMany
    {
        return $this->hasMany(doctor::class);
    }
}
