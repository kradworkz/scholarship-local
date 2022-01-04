<?php

namespace App\Http\Controllers\Lists;

use App\Models\Course;
use App\Models\Agency;
use App\Models\School;
use App\Models\SchoolCampus;
use App\Models\LocationRegion;
use App\Models\LocationProvince;
use App\Models\LocationMunicipality;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\SchoolListResource;
use App\Http\Resources\SchoolsResource;

class ListController extends Controller
{
    public function agencies($keyword,$count){
        ($keyword == '-') ? $keyword = '' : $keyword;
        $data = Agency::where(function ($query) use ($keyword) {
            $query->where('name', 'LIKE', '%'.$keyword.'%')
            ->orWhere('code', 'LIKE', '%'.$keyword.'%')
            ->orWhere('acronym', 'LIKE', '%'.$keyword.'%');
        })
        ->orderBy('id','DESC')->paginate($count);
        return DefaultResource::collection($data);
    }

    public function courses($keyword,$count){
        ($keyword == '-') ? $keyword = '' : $keyword;
        $data = Course::where(function ($query) use ($keyword) {
            $query->where('name', 'LIKE', '%'.$keyword.'%');
        })
        ->orderBy('id','DESC')->paginate($count);
        return DefaultResource::collection($data);
    }

    public function schools($keyword,$count){
        ($keyword == '-') ? $keyword = '' : $keyword;
        $data = SchoolCampus::with('school')
        ->whereHas('school',function ($query) use ($keyword) {
            $query->where('name', 'LIKE', '%'.$keyword.'%');
        })
        ->orWhere(function ($query) use ($keyword) {
            $query->where('campus', 'LIKE', '%'.$keyword.'%');
        })->paginate($count);
        return SchoolsResource::collection($data);
    }

    public function regions()
    {
        $data = LocationRegion::orderBy('id','ASC')->get();
        return DefaultResource::collection($data);
    }

    public function provinces($id = null)
    {
        $data = LocationProvince::where('region_code',$id)->orderBy('name','ASC')->get();
        return DefaultResource::collection($data);
    }

    public function municipalities($id = null)
    {
        $data = LocationMunicipality::where('province_code',$id)->orderBy('name','ASC')->get();
        return DefaultResource::collection($data);
    }
}
