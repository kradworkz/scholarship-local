<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScholarFinancialList extends Model
{
    use HasFactory;

    
    public function financial()
    {
        return $this->belongsTo('App\Models\ScholarFinancial', 'financial_id', 'id');
    }

    public function benefit()
    {
        return $this->belongsTo('App\Models\Dropdown', 'benefit_id', 'id');
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getFlagAttribute($value)
    {
        if($this->benefit_id == 17){
            if($value == 1){
                return 'January';
            }else if($value == 2){
                return 'February';
            }else if($value == 3){
                return 'March';
            }else if($value == 4){
                return 'April';
            }else if($value == 5){
                return 'May';
            }else if($value == 6){
                return 'June';
            }else if($value == 7){
                return 'July';
            }else if($value == 8){
                return 'August';
            }else if($value == 9){
                return 'September';
            }else if($value == 10){
                return 'October';
            }else if($value == 11){
                return 'November';
            }else{
                return 'December';
            }
        }else{
            return $value;
        }
    }
}
