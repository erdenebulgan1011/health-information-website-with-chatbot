<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    protected $fillable = [
        'user_id',
        'specialization',
        'qualification',
        'certification', //

        'bio',
        'is_verified',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function doctorInfo()
{
    return $this->hasOne(DoctorInfo::class);
}

}
