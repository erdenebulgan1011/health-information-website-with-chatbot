<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class VrContentSuggestion extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'sketchfab_uid',
        'category_id',
        'user_id',
        'status',
        'admin_notes'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
