<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dropdown extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function status()
    {
        return $this->hasMany('App\Models\Scholar', 'status_id');
    } 

    public function category()
    {
        return $this->hasMany('App\Models\Scholar', 'category_id');
    } 

    public function expenses()
    {
        return $this->hasMany('App\Models\ListExpense', 'expenditure_id');
    } 

    public function getNameAttribute($value){
        if($this->classification == "Category"){
            return strtoupper($value);
        }else{
            return ucwords($value);
        }
    }

    public function getColorAttribute($value)
    {
        if($value == 'violet' ){
            return 'primary';
        }else if($value == 'blue'){
            return 'info';
        }else if($value == 'red'){
            return 'danger';
        }else if($value == 'yellow'){
            return 'warning';
        }else if($value == 'black'){
            return 'dark';
        }else if($value == 'gray'){
            return 'secondary';
        }else{
            return 'success';
        }
    }
}
