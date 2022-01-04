<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\SchoolCampus;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\SchoolListResource;

class ListController extends Controller
{
    public function schools(Request $request){

        $keyword = $request->input('word');
        $data = SchoolCampus::with('school')
        ->whereHas('school',function ($query) use ($keyword) {
            $query->where('name', 'LIKE', '%'.$keyword.'%');
        })
        ->orWhere(function ($query) use ($keyword) {
            $query->where('campus',$keyword);
        })->get()->take(5);

        return SchoolListResource::collection($data);
    }

    public function courses(Request $request){
        $keyword = $request->input('word');
        $data = Course::where('name','LIKE','%'.$keyword.'%')->get()->take(5);
        return DefaultResource::collection($data);
    }
}
