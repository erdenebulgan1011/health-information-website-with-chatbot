<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VRContentDetail extends Model
{
    protected $table = 'vr_content_details';  // Explicit table name
    
    protected $fillable = [
        'vr_content_id',
        'title', 
        'content',
        'order'
    ];

    public function vrContent()
    {
        return $this->belongsTo(VRContent::class);
    }


}
