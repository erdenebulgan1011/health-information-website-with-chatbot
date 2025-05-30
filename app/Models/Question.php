<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Question extends Model
{
    //
    use HasFactory;

    protected $casts = [
        'options' => 'array',
    ];

    public function testCategory()
    {
        return $this->belongsTo(TestCategory::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

}
