<?php

namespace App\Http\Traits;
use App\Models\Allotment;
use App\Http\Resources\DefaultResource;

trait AccountingTrait {
    public static function allotment() 
    {
        $type = 'DOST';
        $year = date('Y');
;       $count = Allotment::count();
        
		return $routingslip = $type."-".($count+1)."-".$year;  
    }
}