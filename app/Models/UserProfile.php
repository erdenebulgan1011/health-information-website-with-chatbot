<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class UserProfile extends Model
{
    //
    use HasFactory;

    protected $fillable = ['user_id','profile_pic','birth_date', 'gender', 'height','weight','is_smoker', 'has_chronic_conditions', 'medical_history'];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'date',
        'is_smoker' => 'boolean',
        'has_chronic_conditions' => 'boolean',
        'height' => 'integer',
        'weight' => 'integer',
    ];
public function hasMedicalKeyword(string $keyword): bool
    {
        if (empty($this->medical_history)) {
            return false;
        }

        return stripos($this->medical_history, $keyword) !== false;
    }

    /**
     * Get formatted medical history for display (with line breaks)
     */
    public function getFormattedMedicalHistory(): string
    {
        if (empty($this->medical_history)) {
            return 'Эмнэлгийн түүх бичигдээгүй байна.';
        }

        // Replace line breaks and format for better display
        return nl2br(e($this->medical_history));
    }

    /**
     * Get medical history word count (useful for validation)
     */
    public function getMedicalHistoryWordCount(): int
    {
        if (empty($this->medical_history)) {
            return 0;
        }

        return str_word_count($this->medical_history);
    }

    /**
     * Check if medical history is comprehensive (has minimum content)
     */
    public function hasComprehensiveMedicalHistory(): bool
    {
        return $this->getMedicalHistoryWordCount() >= 10; // At least 10 words
    }

    /**
     * Get medical history summary (first 100 characters)
     */
    public function getMedicalHistorySummary(): string
    {
        if (empty($this->medical_history)) {
            return 'Мэдээлэл алга';
        }

        return Str::limit($this->medical_history, 100);
    }


public function getMedicalHistoryListAttribute()
    {
        if (is_array($this->medical_history)) {
            return $this->medical_history;
        }
        return array_map('trim', explode(',', $this->medical_history));
    }

    // Count of medical conditions
    public function getMedicalConditionCountAttribute()
    {
        return count($this->medical_history_list);
    }

    // Check if the user has a specific condition
    public function hasCondition(string $condition): bool
    {
        return in_array(strtolower($condition), array_map('strtolower', $this->medical_history_list));
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get the full URL to the profile picture.
     *
     * @return string|null
     */
    public function getProfilePicUrlAttribute()
    {
        if (!$this->profile_pic) {
            return null;
        }

        return Storage::disk('public')->url($this->profile_pic);
    }
    /**
     * Get a default image if no profile pic exists.
     *
     * @return string
     */
    public function getProfilePicDefaultAttribute()
    {
        return $this->profile_pic
            ? Storage::disk('public')->url($this->profile_pic)
            : asset('images/default-avatar.png');
    }

    /**
     * Delete the profile picture when the model is deleted.
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($profile) {
            if ($profile->profile_pic && Storage::disk('public')->exists($profile->profile_pic)) {
                Storage::disk('public')->delete($profile->profile_pic);
            }
        });
    }
    public function aiRecommendations()
{
    return $this->hasMany(AiRecommendation::class, 'user_profile_id');
}
public static function getRandomDefaultAvatar()
    {
        $randomNumber = rand(1, 14);
        return "images/default_{$randomNumber}.png";
    }


}
