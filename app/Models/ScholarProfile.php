<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScholarProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname', 
        'lastname', 
        'middlename',
        'suffix',
        'gender',
        'mobile',
        'avatar',
        'information'
    ];

    public function scholar()
    {
        return $this->belongsTo('App\Models\Scholar', 'scholar_id', 'id');
    }
    
    public function getFirstnameAttribute($value){
        return ucwords($value);
    }

    public function getLastnameAttribute($value){
        return ucwords($value);
    }

    public function getMiddlenameAttribute($value){
        return ucwords($value);
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
