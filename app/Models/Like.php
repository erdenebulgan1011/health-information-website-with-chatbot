<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'likeable_id',
        'likeable_type',
    ];

    /**
     * Get the parent likeable model (Topic or Reply).
     */
    public function likeable()
    {
        return $this->morphTo();
    }

    /**
     * Get the user who liked this model.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
