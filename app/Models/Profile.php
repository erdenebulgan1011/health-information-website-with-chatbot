<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    //
    protected $fillable = ['user_id', 'avatar', 'bio']; // Add other fields

public function user()
{
    return $this->belongsTo(User::class);
}

}
