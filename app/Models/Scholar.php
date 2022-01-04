<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholar extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'lrn', 
        'spas', 
        'category_id',
        'status_id',
        'course_id',
        'school_id',
        'profile_id',
        'awarded_year',
        'is_completed',
    ];

    public function profile()
    {
        return $this->belongsTo('App\Models\Profile', 'profile_id', 'id');
    }

    public function address()
    {
        return $this->hasOne('App\Models\ScholarAddress', 'scholar_id');
    } 

    // public function profile()
    // {
    //     return $this->hasOne('App\Models\ScholarProfile', 'scholar_id');
    // } 

    // public function financials()
    // {
    //     return $this->hasMany('App\Models\ScholarFinancial', 'scholar_id');
    // } 

    
    public function tracer()
    {
        return $this->hasMany('App\Models\ScholarTracer', 'scholar_id');
    } 

    public function statuses()
    {
        return $this->hasMany('App\Models\ScholarStatus', 'scholar_id');
    } 

    public function status()
    {
        return $this->belongsTo('App\Models\Dropdown', 'status_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Dropdown', 'category_id', 'id');
    }    

    public function course()
    {
        return $this->belongsTo('App\Models\Course', 'course_id', 'id');
    }

    public function school()
    {
        return $this->belongsTo('App\Models\SchoolCampus', 'school_id', 'id');
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }
}
