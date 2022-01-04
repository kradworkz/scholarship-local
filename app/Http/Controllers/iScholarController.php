<?php

namespace App\Http\Controllers;

use Hashids\Hashids; 
use App\Models\Scholar;
use App\Models\Qualifier;
use Illuminate\Http\Request;
use App\Http\Resources\ScholarResource;

class iScholarController extends Controller
{   
    public function lists($status,$category,$count,$year,$keyword){
        ($keyword == '-') ? $keyword = '' : $keyword;
        $data = Scholar::with('profile')->with('school.school')
        ->whereHas('profile',function ($query) use ($keyword) {
            $query->where(\DB::raw('concat(firstname," ",lastname)'), 'LIKE', '%'.$keyword.'%')->orWhere(\DB::raw('concat(lastname," ",firstname)'), 'LIKE', '%'.$keyword.'%');
        })
        ->where(function ($query) use ($category,$status,$year) {
            ($category == '-') ? '' : $query->where('category_id',$category);
            ($status == '-') ? '' : $query->where('status_id',$status);
            ($year == '-') ? '' : $query->where('awarded_year',$year);
        })
        ->orderBy('id','DESC')->paginate($count);
        return ScholarResource::collection($data);
    }

    public function store(Request $request){

        $data = \DB::transaction(function () use ($request){
            if($request->editable == "true"){
                $data = Scholar::findOrFail($request->id);
                $data->update($request->except('img','editable'));
                $profile = ScholarProfile::where('scholar_id',$request->id)->first();
                $profile->update($request->except('email','img','editable'));
                return $data;
            }else{
                // $parents = [
                //     'mother' => $request->mother,
                //     'father' => $request->father,
                // ];
                // $information = [
                //     'social' => $request->social,
                //     'email' => $request->email,
                //     'parents' => $parents,
                // ];
                $data = Scholar::create($request->all());
                $data->address()->create(array_merge($request->all(), ['type' => 'original']));
                // $this->storeImage($request,$data->id);
                if($data){
                    $wee = Qualifier::where('id',$request->qualifier_id)->update(['is_qualified' => 1]);
                    return $data;
                }
            }
        });
        return new ScholarResource($data);
    }

    public function view($id){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($id);
        $data = Scholar::with('profile')->where('id',$id)->first();
        return new ScholarResource($data);
    }   
}
