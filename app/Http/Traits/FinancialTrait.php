<?php

namespace App\Http\Traits;

use App\Models\Dropdown;
use App\Models\Scholar;
use App\Models\ScholarFinancialList;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\FinancialResource;
use Hashids\Hashids; 

trait FinancialTrait {
    
    public function check($id,$benefit_id,$term,$ay) {
        
        $query = ScholarFinancialList::query();
        $query->with('financial')->where('benefit_id',$benefit_id);
        ($term != null) ? $query->where('flag',$term) : '';
        $query->whereHas('financial',function ($query) use ($id,$ay){
            $query->where('scholar_id',$id);
            ($ay != null) ? $query->where('academic_year',$ay) : '';
        });
        $data = $query->latest()->first();
        

        if(is_null($data)){
            return '';
        }else{
            return new FinancialResource($data);
        }
    }
}