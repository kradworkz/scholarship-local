<?php

namespace App\Http\Controllers;

use App\Models\Qualifier;
use App\Models\Scholar;
use Illuminate\Http\Request;
use App\Http\Resources\QualifierResource;

class QualifierController extends Controller
{
    public function index($count,$category,$year,$keyword){
        ($keyword == '-') ? $keyword = '' : $keyword;
        $data = Qualifier::with('profile')
        ->whereHas('profile',function ($query) use ($keyword) {
            $query->where(\DB::raw('concat(firstname," ",lastname)'), 'LIKE', '%'.$keyword.'%')->orWhere(\DB::raw('concat(lastname," ",firstname)'), 'LIKE', '%'.$keyword.'%');
        })
        ->where(function ($query) use ($category,$year) {
            $query->where('is_qualified',NULL);
            ($category == '-') ? '' : $query->where('category_id',$category);
            ($year == '-') ? '' : $query->where('year',$year);
        })
        ->orderBy('id','DESC')->paginate($count);
        return QualifierResource::collection($data);
    }
}
