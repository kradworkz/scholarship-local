<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qualifier extends Model
{
    use HasFactory;

    protected $fillable = [
        'lrn',
        'category_id',
        'applicant_id',
        'school_code',
        'course_id',
        'profile_id',
        'is_qualified',
        'year'
    ];

    public function profile()
    {
        return $this->belongsTo('App\Models\Profile', 'profile_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Dropdown', 'category_id', 'id');
    }  
}
