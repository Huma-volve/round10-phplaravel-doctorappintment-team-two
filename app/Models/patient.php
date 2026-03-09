<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
<<<<<<< HEAD
    //
=======
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoriteDoctors(): BelongsToMany
    {
        return $this->belongsToMany(Doctor::class, 'favorites');
    }
>>>>>>> 09621b2ad9c9f16f2bd78156f87a0655c864e7b3
}
