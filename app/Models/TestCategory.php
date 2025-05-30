<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class TestCategory extends Model
{
    //
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'icon', 'is_active'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function testSessions()
    {
        return $this->hasMany(TestSession::class);
    }

    public function recommendations()
    {
        return $this->hasMany(Recommendation::class);
    }

}
