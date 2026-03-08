<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Notifications;

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

    public static function rules()
    {
        return [
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'unique:users,email'],
            'password'      => ['nullable', 'same:confirm_password'],
            'role'          => ['required', 'in:admin,patient,doctor'],
            'mobile_number' => ['required', 'string', 'max:20'],
            'birthdate'     => ['nullable', 'date'],
            'latitude'      => ['nullable', 'required', 'numeric'],
            'longitude'     => ['nullable', 'required', 'numeric'],
        ];
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function patient(): HasOne
    {
        return $this->hasOne(Patient::class);
    }

    public function chats()
    {
        return $this->belongsToMany(Chat::class, 'chat_user')
            ->withPivot('is_favorite', 'last_read_at')
            ->withTimestamps();
    }
    /**
     * Notifications Relationships
     */
    public function notifications()
    {
        return $this->hasMany(Notifications::class)
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
