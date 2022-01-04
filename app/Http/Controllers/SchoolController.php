<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\SchoolListResource;

class SchoolController extends Controller
{   
    public function lists(){
        $data = SchoolCampus::with('school')->get();
        return SchoolListResource::collection($data);
    }
    
    public function index($count,$term,$grade,$class,$keyword){
        ($keyword == '-') ? $keyword = '' : $keyword;
        $data = School::with('term')->with('class')->with('grading')
        ->where(function ($query) use ($keyword) {
            $query->where('name', 'LIKE', '%'.$keyword.'%')->orWhere('deped_id', 'LIKE', '%'.$keyword.'%');
        })
        ->where(function ($query) use ($term,$grade,$class) {
            ($term == '-') ? '' : $query->where('term_id',$term);
            ($grade == '-') ? '' : $query->where('grade_id',$grade);
            ($class == '-') ? '' : $query->where('class_id',$class);
        })
        ->orderBy('id','DESC')->paginate($count);
        return DefaultResource::collection($data);
    }
}
