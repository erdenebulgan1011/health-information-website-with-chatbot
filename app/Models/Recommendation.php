<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Recommendation extends Model
{
    use HasFactory;

    public function testCategory()
    {
        return $this->belongsTo(TestCategory::class);
    }
}
