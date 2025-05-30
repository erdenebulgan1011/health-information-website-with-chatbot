<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class TestSession extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', // Add this line

        'test_session_id', // Add this line

        'test_category_id',
        'completed_at' => 'datetime',  // Automatically casts 'completed_at' to a Carbon instance
        'results' => 'array',  // Automatically casts 'results' to an array

 
 
    ];


    protected $casts = [


        

        'results' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function testCategory()
    {
        return $this->belongsTo(TestCategory::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }
}
