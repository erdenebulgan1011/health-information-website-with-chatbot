<?php

namespace App\Providers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Listen for user created event and create profile with random avatar
        User::created(function ($user) {
            // Only create profile if it doesn't exist yet
            if (!$user->profile) {
                $user->profile()->create([
                    'profile_pic' => UserProfile::getRandomDefaultAvatar(),
                ]);
            }
        });
    }
}
