<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Response extends Model
{
    use HasFactory;
    protected $fillable = [
        'test_session_id',  // Add this line
        'question_id',
        'response_value',
        'score'
    ];


    public function testSession()
    {
        return $this->belongsTo(TestSession::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
