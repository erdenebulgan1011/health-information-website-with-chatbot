<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_id',
        'full_name',
        'phone_number',
        'workplace',
        'address',
        'education',
        'years_experience',
        'languages',
    ];

    /**
     * Get the professional record associated with this doctor info.
     */
    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

}
