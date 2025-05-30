<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Notifications\ResetPasswordNotification;


class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'google2fa_secret',
        'google2fa_enabled'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'google2fa_secret',
    ];

    protected $casts = [
        'google2fa_enabled' => 'boolean',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean', // Cast to boolean
    ];

public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Handle the encryption of 2FA secret
     */
    public function setGoogle2faSecretAttribute($value)
    {
        $this->attributes['google2fa_secret'] = $value ? encrypt($value) : null;
    }

    /**
     * Decrypt the 2FA secret when accessing it
     */
    public function getGoogle2faSecretAttribute($value)
    {
        return $value ? decrypt($value) : null;
    }

    /**
     * Check if 2FA is enabled for the user
     */
    public function getHasTwoFaAttribute()
    {
        return $this->google2fa_enabled && $this->google2fa_secret;
    }


    public function vrContents()
    {
        return $this->hasMany(VRContent::class);
    }

    public function savedContent()
    {
        return $this->belongsToMany(VRContent::class, 'saved_content')->withTimestamps();
    }

    // public function isAdmin()
    // {
    //     return $this->is_admin === 1;
    // }
    public function isAdmin(): bool
    {
        return $this->is_admin;
    }
    public function makeAdmin(): void
    {
        $this->update(['is_admin' => true]);
    }

    /**
     * Remove admin privileges
     */
    public function removeAdmin(): void
    {
        $this->update(['is_admin' => false]);
    }
    public function profile()
{
    return $this->hasOne(UserProfile::class);
}
// In User model
public function professional()
{
    return $this->hasOne(Professional::class);
}
public function topics()
    {
        return $this->hasMany(Topic::class);
    }
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
    public function vrContentSuggestions()
    {
        // return $this->belongsTo(vrContentSuggestion::class);
  return $this->hasMany(vrContentSuggestion::class, 'user_id', 'id');
    }
    protected static function booted()
    {
        static::created(function ($user) {
            // Create profile with random avatar when user is created
            $user->profile()->create([
                'profile_pic' => UserProfile::getRandomDefaultAvatar(),
            ]);
        });
    }

}
