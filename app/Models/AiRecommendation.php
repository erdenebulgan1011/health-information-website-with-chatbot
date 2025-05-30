<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiRecommendation extends Model
{
    protected $table = 'ai_recommendations';

    protected $fillable = [
        'user_profile_id',
        'insights',
    ];

    // Relationship back to the user profile
    public function profile()
    {
        return $this->belongsTo(UserProfile::class, 'user_profile_id');
    }
}
