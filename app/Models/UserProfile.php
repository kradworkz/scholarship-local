<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class UserProfile extends Model
{
    use HasFactory, LogsActivity;

    protected static $logName = 'user';
    protected static $recordEvents = ['updated'];
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
    protected $fillable = [
        'firstname', 
        'lastname', 
        'middlename',
        'suffix',
        'gender',
        'mobile'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
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
