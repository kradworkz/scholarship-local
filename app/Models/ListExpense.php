<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListExpense extends Model
{
    use HasFactory;

    protected $fillable = ['name','code','expenditure_id'];

    public function type()
    {
        return $this->belongsTo('App\Models\Dropdown', 'expenditure_id', 'id');
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
