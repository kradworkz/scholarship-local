<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'mobile',
        'firstname', 
        'lastname', 
        'middlename',
        'suffix',
        'gender',
        'mobile',
        'avatar',
        'birthday',
        'information'
    ];

    public function qualifier()
    {
        return $this->hasOne('App\Models\Qualifier', 'profile_id');
    } 

    public function getBirthdayAttribute($value)
    {
        return date('M d, Y', strtotime($value));
    }

}
