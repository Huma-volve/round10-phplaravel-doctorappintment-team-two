<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\notifications;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile_number',
        'birthdate',
        'profile_photo',
        'role',
        'latitude',
        'longitude',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function patient(): HasOne
    {
        return $this->hasOne(patient::class);
    }

    public function doctor(): HasOne
    {
        return $this->hasOne(doctor::class);
    }
    /**
     * Notifications Relationships
     */
    public function notifications()
    {
        return $this->hasMany(notifications::class)
            ->orderBy('created_at', 'desc');
    }

    public function unreadNotifications()
    {
        return $this->notifications()->unread();
    }

    public function unreadNotificationsCount()
    {
        return $this->unreadNotifications()->count();
    }

    public function markAllNotificationsAsRead()
    {
        $this->notifications()
            ->unread()
            ->update(['is_read' => true, 'read_at' => now()]);
    }
}
