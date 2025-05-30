<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories'; // Хүснэгтийн нэрийг зааж өгнө


    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
    ];

    public function vrContents()
    {
        return $this->hasMany(VRContent::class, 'category_id', 'id');
    }
    public function topics()
{
    return $this->hasMany(Topic::class);
}


}
