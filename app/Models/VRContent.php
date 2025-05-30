<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VRContent extends Model
{
    use HasFactory;
    protected $table = 'vr_contents';

    protected $fillable = [
        'title',
        'description',
        'sketchfab_uid',
        'category_id',
        'status',
        'featured',
        'metadata',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'metadata' => 'array',
    ];

    /**
     * Энэ VR контенттой холбоотой эрүүл мэндийн ангилал
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * VR контент дэлгэрэнгүй мэдээлэл
     */
    public function details()
    {
    // return $this->belongsTo(Category::class, 'category_id');
    return $this->hasMany(VRContentDetail::class, 'vr_content_id');

    }

    /**
     * Sketchfab-н бүрэн embed URL
     */
    public function getEmbedUrlAttribute()
    {
        return "https://sketchfab.com/models/{$this->sketchfab_uid}/embed";
    }

}
