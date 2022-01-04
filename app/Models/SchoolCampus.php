<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolCampus extends Model
{
    use HasFactory;

    protected $fillable = [
        'campus',
        'address',
        'is_main',
        'municipality_code',
        'school_id',
        'has_jhs',
        'has_shs',
        'has_tertiary'
    ];

    public function municipality()
    {
        return $this->belongsTo('App\Models\LocationMunicipality', 'municipality_code', 'code');
    }

    public function school()
    {
        return $this->belongsTo('App\Models\School', 'school_id', 'id');
    }

    public function getCampusAttribute($value){
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
