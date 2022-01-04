<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allotment extends Model
{
    use HasFactory;

    protected $fillable = ['code','check_no','checked_at','credited_at','remarks','added_by'];

    public function lists()
    {
        return $this->hasMany('App\Models\AllotmentList', 'allotment_id');
    } 

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'added_by', 'id');
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
