<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'user_id',
        'category_id',
        'views',
        'is_pinned',
        'is_locked',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }



    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function bestAnswer()
    {
        return $this->replies()->where('is_best_answer', true)->first();
    }
    public function replies()
    {
        return $this->hasMany(Reply::class)->with('user');
    }

    public static function boot()
{
    parent::boot();

    static::creating(function ($topic) {
        $recentDuplicate = static::where('user_id', $topic->user_id)
            ->where('title', $topic->title)
            ->where('created_at', '>', now()->subMinutes(5))
            ->exists();

        if ($recentDuplicate) {
            return false; // Prevent save
        }
    });
}
public function getRouteKeyName()
{
    return 'slug';
}


}
