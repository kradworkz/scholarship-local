<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use \Spatie\WelcomeNotification\ReceivesWelcomeNotification;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, ReceivesWelcomeNotification, LogsActivity; 

    protected static $logName = 'user';
    protected static $recordEvents = ['created','updated'];
    protected static $ignoreChangedAttributes = ['password','avatar','welcome_valid_until'];
    protected static $logAttributes = ['email','is_active'];
    protected static $logOnlyDirty = true;
    protected $fillable = [
        'email',
        'password',
        'role',
        'is_active',
        'avatar'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile()
    {
        return $this->hasOne('App\Models\UserProfile', 'user_id');
    } 

    public function hasRole($roles)
    {
        foreach ($roles as $role) {
            if ($this->type == $role) {
                return true;
            }
        }
        return false;
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }
}
