<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Disease extends Model {
    use HasFactory;

    use Searchable;
    protected $fillable = ['disease_id', 'disease_name', 'common_symptom', 'treatment'];
}

