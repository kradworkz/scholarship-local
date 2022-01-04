<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScholarAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'region_id', 'province_id', 'municipality_id', 'address', 'type', 'scholar_id'
    ];

    public function scholar()
    {
        return $this->belongsTo('App\Models\Scholar', 'scholar_id', 'id');
    }

    public function region()
    {
        return $this->belongsTo('App\Models\LocationRegion', 'region_id', 'id');
    }

    public function province()
    {
        return $this->belongsTo('App\Models\LocationProvince', 'province_id', 'id');
    }

    public function municipality()
    {
        return $this->belongsTo('App\Models\LocationMunicipality', 'municipality_id', 'id');
    }

    public function school()
    {
        return $this->belongsTo('App\Models\School', 'school_id', 'id');
    }

    public function getAddressAttribute($value){
        return ucwords(strtolower($value));
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
