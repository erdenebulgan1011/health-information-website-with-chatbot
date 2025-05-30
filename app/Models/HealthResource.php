<?php
// app/Models/HealthResource.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthResource extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'file_path',
        'category_id',
        'user_id',
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
