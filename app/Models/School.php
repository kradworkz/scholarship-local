<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_jlss',
        'is_undergrad',
        'class_id',
        'term_id',
        'grading_id',
        'deped_id',
    ];

    public function campuses()
    {
        return $this->hasMany('App\Models\SchoolCampus', 'school_id');
    } 

    public function campus()
    {
        return $this->hasMany('App\Models\SchoolCampus', 'school_id')->count();
    } 

    public function class()
    {
        return $this->belongsTo('App\Models\Dropdown', 'class_id', 'id');
    }

    public function term()
    {
        return $this->belongsTo('App\Models\Dropdown', 'term_id', 'id');
    }

    public function grading()
    {
        return $this->belongsTo('App\Models\Dropdown', 'grading_id', 'id');
    }

    public function getNameAttribute($value){
        return strtoupper($value);
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
